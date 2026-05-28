<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use App\Services\MarkdownService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ContentSeeder extends Seeder
{
    public function run(): void
    {
        $markdown = new MarkdownService();

        // Categories
        $categories = collect([
            ['name' => 'Programming', 'description' => 'Software development, languages, frameworks, and best practices.'],
            ['name' => 'Artificial Intelligence', 'description' => 'Machine learning, neural networks, LLMs, and the future of AI.'],
            ['name' => 'DevOps', 'description' => 'CI/CD, containers, infrastructure as code, and cloud platforms.'],
            ['name' => 'Web Development', 'description' => 'Frontend, backend, full-stack, and everything in between.'],
            ['name' => 'Security', 'description' => 'Cybersecurity, encryption, vulnerabilities, and defensive coding.'],
        ])->map(function ($cat) {
            return Category::create([
                'name' => $cat['name'],
                'slug' => Str::slug($cat['name']),
                'description' => $cat['description'],
            ]);
        })->keyBy('name');

        // Tags
        $tags = collect([
            'PHP', 'Laravel', 'JavaScript', 'TypeScript', 'Python',
            'Docker', 'Kubernetes', 'Linux', 'Git', 'REST API',
            'ChatGPT', 'LLM', 'Machine Learning', 'Deep Learning',
            'React', 'Vue.js', 'Node.js', 'SQL', 'NoSQL',
            'CI/CD', 'AWS', 'Performance', 'Architecture', 'Open Source',
            'Rust', 'Go', 'WebAssembly', 'GraphQL', 'Testing',
        ])->map(function ($name) {
            return Tag::create([
                'name' => $name,
                'slug' => Str::slug($name),
            ]);
        })->keyBy('name');

        // Articles
        $articles = $this->getArticles();

        foreach ($articles as $data) {
            $html = $markdown->toHtml($data['body']);
            $readingTime = $markdown->estimateReadingTime($data['body']);

            $article = Article::create([
                'category_id' => $categories[$data['category']]->id,
                'title' => $data['title'],
                'slug' => Str::slug($data['title']),
                'excerpt' => $data['excerpt'],
                'body_markdown' => $data['body'],
                'body_html' => $html,
                'status' => 'published',
                'published_at' => $data['date'],
                'reading_time' => $readingTime,
            ]);

            $articleTags = collect($data['tags'])->map(fn ($t) => $tags[$t]->id);
            $article->tags()->sync($articleTags);
        }
    }

    private function getArticles(): array
    {
        return [
            [
                'title' => 'Building Scalable APIs with Laravel: A Practical Guide',
                'category' => 'Web Development',
                'tags' => ['PHP', 'Laravel', 'REST API', 'Architecture'],
                'date' => '2026-05-28 10:00:00',
                'excerpt' => 'Learn how to design and build production-ready REST APIs with Laravel, covering routing, validation, resource transformations, rate limiting, and versioning strategies.',
                'body' => <<<'MD'
Building a well-structured API is one of the most important skills in modern web development. Laravel provides an exceptional toolkit for this, but knowing which pieces to use — and when — makes the difference between a prototype and a production system.

## Project Setup

Start with a fresh Laravel installation and configure your environment:

```bash
composer create-project laravel/laravel api-project
cd api-project
php artisan install:api
```

The `install:api` command sets up Laravel Sanctum and the API route file. From here, everything lives under `/api`.

## Designing Resource Endpoints

Follow REST conventions strictly. A `Post` resource should expose:

```
GET    /api/posts          → index
POST   /api/posts          → store
GET    /api/posts/{id}     → show
PUT    /api/posts/{id}     → update
DELETE /api/posts/{id}     → destroy
```

In your route file:

```php
Route::apiResource('posts', PostController::class);
```

One line. All five routes. Laravel handles the mapping.

## Request Validation

Never trust client input. Create a dedicated Form Request:

```php
class StorePostRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title'   => ['required', 'string', 'max:255'],
            'body'    => ['required', 'string'],
            'status'  => ['required', 'in:draft,published'],
            'tags'    => ['array'],
            'tags.*'  => ['exists:tags,id'],
        ];
    }
}
```

This keeps your controller thin and your validation testable.

## API Resources for Response Shaping

Never return Eloquent models directly. Use API Resources:

```php
class PostResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'         => $this->id,
            'title'      => $this->title,
            'excerpt'    => Str::limit($this->body, 200),
            'author'     => new UserResource($this->whenLoaded('author')),
            'tags'       => TagResource::collection($this->whenLoaded('tags')),
            'created_at' => $this->created_at->toIso8601String(),
        ];
    }
}
```

This gives you full control over the JSON structure without coupling it to your database schema.

## Rate Limiting

Laravel's rate limiter is middleware-based and highly configurable:

```php
RateLimiter::for('api', function (Request $request) {
    return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
});
```

Authenticated users get 60 requests per minute keyed by user ID; anonymous traffic is keyed by IP. Adjust these numbers based on your actual usage patterns.

## Versioning Strategy

The simplest approach is URI-based versioning:

```php
Route::prefix('v1')->group(function () {
    Route::apiResource('posts', V1\PostController::class);
});

Route::prefix('v2')->group(function () {
    Route::apiResource('posts', V2\PostController::class);
});
```

It's explicit, easy to route, and straightforward to deprecate. Header-based versioning is more "correct" in REST theory, but URI versioning wins in practice for discoverability and debugging.

## Conclusion

A well-built Laravel API is a pleasure to work with. The framework gives you the tools — resource controllers, form requests, API resources, rate limiting — but the architecture decisions are yours. Keep your controllers thin, your validation strict, and your responses consistent.
MD,
            ],

            [
                'title' => 'Understanding Large Language Models: From Transformers to ChatGPT',
                'category' => 'Artificial Intelligence',
                'tags' => ['ChatGPT', 'LLM', 'Deep Learning', 'Python'],
                'date' => '2026-05-25 14:00:00',
                'excerpt' => 'A deep dive into how large language models work under the hood — attention mechanisms, tokenization, training, and why they sometimes hallucinate.',
                'body' => <<<'MD'
Large Language Models have transformed how we interact with computers. But beneath the conversational interface lies a sophisticated architecture worth understanding, whether you're building with LLMs or just trying to use them effectively.

## The Transformer Architecture

Everything starts with the 2017 paper "Attention Is All You Need." The transformer introduced **self-attention** — a mechanism that lets the model weigh the importance of each word relative to every other word in a sequence.

Consider the sentence: "The cat sat on the mat because **it** was tired."

What does "it" refer to? A transformer can learn that "it" attends strongly to "cat" rather than "mat" by computing attention scores across all word pairs simultaneously.

The core self-attention formula:

$$\text{Attention}(Q, K, V) = \text{softmax}\left(\frac{QK^T}{\sqrt{d_k}}\right)V$$

Where Q (queries), K (keys), and V (values) are learned projections of the input embeddings.

## Tokenization

LLMs don't see words — they see **tokens**. Most modern models use byte-pair encoding (BPE) or similar subword tokenization:

```
"Understanding" → ["Under", "stand", "ing"]
"ChatGPT"       → ["Chat", "G", "PT"]
"🤖"            → [token_id: 93457]
```

This is why token count matters more than word count for context windows, and why some words cost more tokens than others.

## The Training Pipeline

Training an LLM like GPT involves three major stages:

**1. Pre-training** — The model reads vast amounts of text and learns to predict the next token. This is unsupervised and extremely compute-intensive. GPT-4 reportedly used tens of thousands of GPUs for months.

**2. Supervised Fine-Tuning (SFT)** — Human annotators write example conversations showing ideal assistant behavior. The model is fine-tuned on these examples.

**3. RLHF (Reinforcement Learning from Human Feedback)** — Human raters rank multiple model outputs. A reward model learns these preferences, and the LLM is optimized against it using PPO or similar algorithms.

## Why Hallucinations Happen

LLMs are fundamentally **next-token predictors**. They don't have a database of facts — they have statistical patterns over token sequences. When asked about something outside their training data (or at the boundary of it), they generate the most probable continuation, which may be entirely fabricated.

```
User: "Who won the Nobel Prize in Literature in 2025?"
LLM:  "The 2025 Nobel Prize in Literature was awarded to..."
       → May confidently generate a plausible but wrong answer
```

This isn't a bug — it's an inherent property of the architecture. Retrieval-augmented generation (RAG) mitigates this by grounding responses in actual documents.

## Practical Implications for Developers

When building with LLMs:

- **Always validate outputs** — never trust LLM output for factual claims without verification
- **Use structured output** — request JSON or specific formats to make parsing reliable
- **Manage context windows** — be deliberate about what goes into the prompt
- **Temperature matters** — use low temperature (0.0-0.3) for factual tasks, higher (0.7-1.0) for creative ones
- **Cost scales with tokens** — optimize prompts to reduce unnecessary verbosity

## Looking Ahead

The field is moving fast. Multi-modal models that process text, images, and audio together are becoming standard. Smaller, more efficient models are challenging the "bigger is better" paradigm. And tool-use capabilities are turning LLMs from text generators into general-purpose reasoning engines.

Understanding the fundamentals helps you navigate the hype and build systems that leverage these models effectively.
MD,
            ],

            [
                'title' => 'Docker in Production: Lessons Learned the Hard Way',
                'category' => 'DevOps',
                'tags' => ['Docker', 'Linux', 'CI/CD', 'Architecture'],
                'date' => '2026-05-22 09:30:00',
                'excerpt' => 'Real-world lessons from running Docker containers in production for three years — from image optimization to health checks, logging, and the mistakes that cost us downtime.',
                'body' => <<<'MD'
Docker makes development environments reproducible and deployments predictable. But running containers in production requires a different mindset than building `docker-compose.yml` files for local development. Here are the lessons that cost us real downtime.

## Lesson 1: Your Images Are Too Big

Our first production image was 1.2 GB. Pulls took forever, deploys were slow, and our container registry bill was painful.

The fix is multi-stage builds:

```dockerfile
# Build stage
FROM node:20-alpine AS builder
WORKDIR /app
COPY package*.json ./
RUN npm ci --production=false
COPY . .
RUN npm run build

# Production stage
FROM node:20-alpine
WORKDIR /app
COPY --from=builder /app/dist ./dist
COPY --from=builder /app/node_modules ./node_modules
COPY package*.json ./
USER node
EXPOSE 3000
CMD ["node", "dist/server.js"]
```

Result: 180 MB instead of 1.2 GB. Use Alpine base images, multi-stage builds, and `.dockerignore` religiously.

## Lesson 2: Health Checks Are Not Optional

Without health checks, your orchestrator has no way to know if your application is actually serving traffic:

```dockerfile
HEALTHCHECK --interval=30s --timeout=3s --retries=3 \
  CMD wget -qO- http://localhost:3000/health || exit 1
```

And in your application, implement a real health endpoint that checks dependencies:

```javascript
app.get('/health', async (req, res) => {
  try {
    await db.query('SELECT 1');
    await redis.ping();
    res.json({ status: 'healthy', uptime: process.uptime() });
  } catch (err) {
    res.status(503).json({ status: 'unhealthy', error: err.message });
  }
});
```

A health check that just returns 200 without verifying dependencies is lying to your orchestrator.

## Lesson 3: Don't Run as Root

Every container should run as a non-root user:

```dockerfile
RUN addgroup -g 1001 appgroup && \
    adduser -u 1001 -G appgroup -s /bin/sh -D appuser
USER appuser
```

This limits the blast radius if your application is compromised. Combined with read-only root filesystems and dropped capabilities, it's defense in depth.

## Lesson 4: Log to stdout

Don't write log files inside containers. Containers are ephemeral — when they restart, those logs are gone.

```javascript
// Bad
const logger = winston.createLogger({
  transports: [new winston.transports.File({ filename: '/var/log/app.log' })]
});

// Good
const logger = winston.createLogger({
  transports: [new winston.transports.Console()]
});
```

Write to stdout/stderr. Let Docker's logging driver (or your orchestrator's log collector) handle aggregation, rotation, and shipping.

## Lesson 5: Pin Your Versions

```dockerfile
# Dangerous
FROM node:latest

# Safer
FROM node:20-alpine

# Best
FROM node:20.11.1-alpine3.19
```

`latest` is a moving target. A surprise Node.js major version bump on a Friday afternoon deploy is not how you want to spend your weekend.

## Lesson 6: Graceful Shutdown

Docker sends SIGTERM before SIGKILL. Handle it:

```javascript
process.on('SIGTERM', async () => {
  console.log('SIGTERM received, shutting down gracefully...');
  server.close(() => {
    db.end();
    process.exit(0);
  });
  setTimeout(() => process.exit(1), 10000);
});
```

Without this, in-flight requests get killed mid-response, database connections leak, and your users see errors during deploys.

## The Bottom Line

Docker in production is about discipline: small images, health checks, non-root users, stdout logging, pinned versions, and graceful shutdown. None of these are complicated individually, but skipping any one of them will eventually cause a production incident.
MD,
            ],

            [
                'title' => 'Rust for Backend Developers: Why the Hype Is Justified',
                'category' => 'Programming',
                'tags' => ['Rust', 'Performance', 'Architecture', 'Open Source'],
                'date' => '2026-05-18 11:00:00',
                'excerpt' => 'A pragmatic look at Rust from the perspective of someone who writes PHP and Python daily. What makes Rust different, where it shines, and whether you should learn it.',
                'body' => <<<'MD'
I spent most of my career writing PHP and Python. Dynamic typing, garbage collection, "move fast and break things." Then I tried Rust, and it fundamentally changed how I think about code.

## The Ownership Model

Rust's killer feature isn't speed — it's the ownership system. Every value has exactly one owner, and when that owner goes out of scope, the value is dropped:

```rust
fn main() {
    let s1 = String::from("hello");
    let s2 = s1; // s1 is MOVED to s2
    // println!("{}", s1); // Compile error! s1 is no longer valid
    println!("{}", s2); // Works fine
}
```

This feels restrictive at first, but it eliminates entire classes of bugs: use-after-free, double-free, data races. The compiler catches them all at build time.

## Zero-Cost Abstractions

Rust's iterators compile down to the same machine code as hand-written loops:

```rust
let sum: i64 = numbers
    .iter()
    .filter(|&&x| x > 0)
    .map(|&x| x * x)
    .sum();
```

This is as fast as a C-style for loop, but far more readable. The abstraction costs nothing at runtime — the compiler optimizes it away entirely.

## Error Handling Done Right

No exceptions. No null pointer dereferences. Rust uses `Result` and `Option` types:

```rust
fn read_config(path: &str) -> Result<Config, ConfigError> {
    let content = std::fs::read_to_string(path)
        .map_err(|e| ConfigError::FileRead(e))?;

    let config: Config = toml::from_str(&content)
        .map_err(|e| ConfigError::Parse(e))?;

    Ok(config)
}
```

The `?` operator propagates errors up the call stack. Every function signature tells you exactly what can go wrong. No hidden exceptions, no surprise panics in production.

## Where Rust Shines for Backend Work

- **CLI tools** — ripgrep, bat, fd, delta — the entire modern CLI ecosystem is Rust
- **High-throughput services** — when your Python service hits a CPU wall, Rust is the answer
- **WebAssembly** — Rust has first-class WASM support for running code in browsers
- **Systems programming** — anything that touches the network, filesystem, or OS directly

## Where Rust Is Overkill

- CRUD web apps with modest traffic (use Laravel, Django, Rails)
- Rapid prototyping where iteration speed matters more than runtime performance
- Small scripts and automation (use Python, Bash)

## The Learning Curve

The borrow checker will fight you for the first few weeks. This is normal. You're unlearning habits from garbage-collected languages. The common progression:

1. **Week 1-2:** "Why won't this compile?"
2. **Week 3-4:** "Oh, the compiler is actually protecting me"
3. **Month 2:** "I can't believe other languages let me do that"
4. **Month 3+:** "This refactor touched 50 files and it worked on the first run"

That last point is real. Rust's type system and ownership model mean that if it compiles, it almost certainly works. Large refactors that would be terrifying in Python become routine.

## Should You Learn Rust?

If you're a backend developer who has ever:
- Debugged a race condition
- Dealt with a memory leak in production
- Hit a CPU bottleneck in Python/PHP/Ruby
- Wanted to write a CLI tool that's actually fast

Then yes. You don't need to rewrite everything in Rust. But having it in your toolkit changes how you approach problems, even in other languages.
MD,
            ],

            [
                'title' => 'The Art of Writing Secure Code: Beyond OWASP Top 10',
                'category' => 'Security',
                'tags' => ['PHP', 'JavaScript', 'Architecture', 'Testing'],
                'date' => '2026-05-15 08:00:00',
                'excerpt' => 'Security isn\'t a checklist — it\'s a mindset. Going beyond the OWASP Top 10 to build applications that are secure by default through design patterns and coding practices.',
                'body' => <<<'MD'
Everyone knows the OWASP Top 10. SQL injection, XSS, CSRF — these are table stakes. But truly secure applications go deeper. Security isn't a feature you add; it's a property that emerges from how you design and write code.

## Principle 1: Fail Closed, Not Open

When something goes wrong, deny access by default:

```php
// Bad: fails open
function isAllowed(User $user, string $permission): bool
{
    try {
        return $this->checkPermission($user, $permission);
    } catch (\Exception $e) {
        return true; // "Let them through, we'll fix it later"
    }
}

// Good: fails closed
function isAllowed(User $user, string $permission): bool
{
    try {
        return $this->checkPermission($user, $permission);
    } catch (\Exception $e) {
        Log::error('Permission check failed', [
            'user' => $user->id,
            'permission' => $permission,
            'error' => $e->getMessage(),
        ]);
        return false;
    }
}
```

If your authorization system is broken, locking everyone out is better than letting everyone in.

## Principle 2: Validate on Input, Encode on Output

Input validation and output encoding serve different purposes. Do both:

```php
// Input: validate and reject bad data
$email = filter_var($input, FILTER_VALIDATE_EMAIL);
if ($email === false) {
    throw new ValidationException('Invalid email');
}

// Output: encode for the context
echo htmlspecialchars($userInput, ENT_QUOTES, 'UTF-8'); // HTML context
echo json_encode($data, JSON_HEX_TAG);                  // JSON context
echo urlencode($param);                                  // URL context
```

Validation prevents bad data from entering your system. Encoding prevents it from being interpreted as code when leaving your system. They are not interchangeable.

## Principle 3: Constant-Time Comparison

String comparison for secrets must be constant-time:

```php
// Bad: timing attack vulnerable
if ($token === $expectedToken) { ... }

// Good: constant-time comparison
if (hash_equals($expectedToken, $token)) { ... }
```

Standard `===` short-circuits on the first mismatched character. An attacker can measure response times to deduce the correct token one character at a time. `hash_equals` always takes the same time regardless of where the strings differ.

## Principle 4: Parameterize Everything

Not just SQL — any string interpolation into a structured language is dangerous:

```php
// SQL injection
$db->query("SELECT * FROM users WHERE id = $id");

// LDAP injection
$ldap->search("(uid=$username)");

// Command injection
exec("convert $filename output.png");

// All fixed the same way: parameterization
$db->prepare("SELECT * FROM users WHERE id = ?")->execute([$id]);
$ldap->search("(uid=?)", [$username]);
$process = new Process(['convert', $filename, 'output.png']);
```

## Principle 5: Least Privilege by Default

Every component should have the minimum permissions it needs:

```sql
-- Don't give your app the root database user
CREATE USER 'webapp'@'%' IDENTIFIED BY 'strong_password';
GRANT SELECT, INSERT, UPDATE, DELETE ON myapp.* TO 'webapp'@'%';
-- No DROP, no ALTER, no GRANT
```

Same principle applies to API keys, file permissions, container capabilities, and IAM roles.

## Principle 6: Audit Logging

You can't investigate what you didn't log:

```php
class AuditLogger
{
    public function log(string $action, User $user, array $context = []): void
    {
        AuditLog::create([
            'action'     => $action,
            'user_id'    => $user->id,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'context'    => $context,
            'created_at' => now(),
        ]);
    }
}

// Usage
$audit->log('article.deleted', $user, ['article_id' => $article->id]);
$audit->log('login.failed', $user, ['email' => $email]);
$audit->log('permission.changed', $admin, ['target_user' => $targetId]);
```

Log authentication events, authorization decisions, data modifications, and admin actions. Make logs immutable — append-only, shipped to external storage.

## The Security Mindset

The common thread across all these principles is **assuming failure**. Assume your validation will be bypassed. Assume your database credentials will leak. Assume your users will be phished.

Security isn't about making attacks impossible — it's about making each layer of defense independent, so that when one fails (and it will), the others still hold.
MD,
            ],

            [
                'title' => 'Modern JavaScript in 2026: What Actually Changed',
                'category' => 'Web Development',
                'tags' => ['JavaScript', 'TypeScript', 'Node.js', 'React'],
                'date' => '2026-05-12 16:00:00',
                'excerpt' => 'A practical overview of the JavaScript features and ecosystem changes that matter in 2026 — from TC39 proposals that landed to the tools that replaced webpack.',
                'body' => <<<'MD'
The JavaScript ecosystem moves fast. Here's what actually matters in 2026, filtering out the noise and focusing on changes that affect how we write code daily.

## Native Decorators Are Here

After years as a TypeScript-only feature, decorators landed in ECMAScript:

```javascript
function log(target, context) {
  const original = target;
  function replacement(...args) {
    console.log(`Calling ${context.name} with`, args);
    return original.apply(this, args);
  }
  return replacement;
}

class UserService {
  @log
  findById(id) {
    return db.query('SELECT * FROM users WHERE id = ?', [id]);
  }
}
```

The spec differs from the TypeScript experimental implementation, so migration requires attention.

## Temporal API Replaces Moment/date-fns

The `Temporal` API is now available in all major browsers and Node.js:

```javascript
const now = Temporal.Now.zonedDateTimeISO();
const meeting = Temporal.ZonedDateTime.from('2026-06-15T14:00[America/New_York]');

const duration = now.until(meeting);
console.log(`Meeting in ${duration.total('days')} days`);

const nextWeek = now.add({ weeks: 1 });
const formatted = nextWeek.toLocaleString('en-US', {
  weekday: 'long',
  month: 'long',
  day: 'numeric'
});
```

No more timezone bugs. No more `new Date()` weirdness. `Temporal` handles dates, times, durations, and timezones correctly by default.

## The Build Tool Landscape

The webpack era is effectively over for new projects:

| Tool | Use Case | Speed |
|------|----------|-------|
| **Vite** | Web apps, SSR | Fast (esbuild + Rollup) |
| **esbuild** | Libraries, bundling | Extremely fast (Go) |
| **Turbopack** | Next.js projects | Fast (Rust) |
| **Bun** | Full runtime + bundler | Fast (Zig) |

Vite won the default spot. It's the bundler for Vue, Svelte, SolidJS, and Laravel. If you're starting a new project, it's almost certainly Vite.

## TypeScript Is Non-Negotiable

The debate is over. TypeScript adoption crossed the tipping point:

```typescript
interface Article {
  id: number;
  title: string;
  tags: string[];
  publishedAt: Date | null;
}

function getPublishedArticles(articles: Article[]): Article[] {
  return articles.filter(
    (a): a is Article & { publishedAt: Date } => a.publishedAt !== null
  );
}
```

The type narrowing, IDE support, and refactoring confidence make it worth the setup cost for any project beyond a script.

## Server Components Changed React

React Server Components (RSC) fundamentally changed how we think about React:

```typescript
// This runs on the server — no client JavaScript
async function ArticleList() {
  const articles = await db.articles.findMany({
    where: { status: 'published' },
    orderBy: { publishedAt: 'desc' },
  });

  return (
    <ul>
      {articles.map(article => (
        <li key={article.id}>
          <a href={`/articles/${article.slug}`}>{article.title}</a>
        </li>
      ))}
    </ul>
  );
}
```

Database queries in components. Zero client-side JavaScript for static content. It took time, but the mental model is clicking.

## What to Learn Next

If you're a JavaScript developer in 2026, prioritize:

1. **TypeScript** — if you haven't already, it's long overdue
2. **Server-first patterns** — RSC, Astro, or similar server-rendering approaches
3. **Edge computing** — Cloudflare Workers, Vercel Edge Functions, Deno Deploy
4. **Temporal API** — replace your date library
5. **Testing with Vitest** — it's the Vite-native test runner and it's excellent

The JavaScript ecosystem is maturing. The churn is slowing. The tools are better. It's a good time to be writing JavaScript.
MD,
            ],

            [
                'title' => 'Kubernetes for Small Teams: You Might Not Need It',
                'category' => 'DevOps',
                'tags' => ['Kubernetes', 'Docker', 'AWS', 'Architecture'],
                'date' => '2026-05-08 12:00:00',
                'excerpt' => 'An honest assessment of when Kubernetes makes sense and when simpler alternatives like Docker Compose, ECS, or even a single VPS will serve you better.',
                'body' => <<<'MD'
Kubernetes is an incredible piece of engineering. It's also massive overkill for most applications. After helping teams both adopt and abandon Kubernetes, here's my honest take on when it makes sense.

## The Kubernetes Tax

Running Kubernetes isn't free. The operational overhead includes:

- **Cluster management** — even managed services (EKS, GKE, AKS) require node pool management, upgrades, and networking configuration
- **YAML sprawl** — a simple web app needs Deployment, Service, Ingress, ConfigMap, Secret, HPA, PDB, and NetworkPolicy manifests
- **Debugging complexity** — "why isn't my pod starting?" involves checking events, logs, resource limits, node taints, admission webhooks, and service mesh sidecars
- **Learning curve** — it takes 3-6 months for a team to become proficient

This is the Kubernetes tax. For large organizations with dedicated platform teams, it's worth paying. For a team of 3-5 developers? Usually not.

## When Kubernetes Makes Sense

You likely need Kubernetes if you have:

- **10+ microservices** that need independent scaling and deployment
- **Multi-team development** where service isolation and resource quotas matter
- **Complex scaling patterns** — different services scaling on different metrics
- **Compliance requirements** that mandate specific network policies and audit trails
- **A platform team** (or at least one dedicated DevOps engineer)

## Simpler Alternatives

### Docker Compose + Single Server

For apps serving under 10,000 concurrent users, a single well-configured server is remarkably capable:

```yaml
services:
  app:
    build: .
    restart: always
    ports:
      - "3000:3000"
    deploy:
      resources:
        limits:
          memory: 512M

  db:
    image: postgres:16-alpine
    volumes:
      - pgdata:/var/lib/postgresql/data

  nginx:
    image: nginx:alpine
    ports:
      - "80:80"
      - "443:443"
```

Add a CDN in front, and this handles more traffic than most startups will ever see.

### Managed Container Services

AWS ECS, Google Cloud Run, or Azure Container Apps give you container orchestration without the Kubernetes complexity:

```bash
# Google Cloud Run: deploy a container in one command
gcloud run deploy my-service \
  --image gcr.io/my-project/my-app:latest \
  --platform managed \
  --region us-central1 \
  --allow-unauthenticated
```

Auto-scaling, TLS, custom domains, revision management — all handled by the platform.

### PaaS Solutions

Railway, Render, Fly.io, or even Heroku (yes, it's still around) handle deployment, scaling, and infrastructure:

```bash
# Fly.io
fly launch
fly deploy
fly scale count 3
```

## The Decision Framework

Ask yourself these questions:

1. Do we have more than 5 independently deployable services? → If no, skip K8s
2. Do we have a dedicated platform/DevOps person? → If no, skip K8s
3. Do we need fine-grained network policies between services? → If no, skip K8s
4. Is our scaling pattern complex (different metrics per service)? → If no, skip K8s
5. Are we required to run on-premises? → If yes, K8s might be your best option

If you answered "no" to most of these, Docker Compose on a managed VPS, or a managed container service, will serve you better with 90% less operational overhead.

## The Real Lesson

The best infrastructure is the one your team can operate confidently. A Docker Compose setup that your entire team understands is better than a Kubernetes cluster that only one person can debug.

Start simple. Add complexity only when the simpler solution demonstrably can't handle your requirements. Not when it "might not scale" — when it actually doesn't.
MD,
            ],

            [
                'title' => 'Git Workflows That Actually Work: Beyond GitFlow',
                'category' => 'Programming',
                'tags' => ['Git', 'CI/CD', 'Architecture', 'Open Source'],
                'date' => '2026-05-05 10:30:00',
                'excerpt' => 'GitFlow is dead for most teams. Here are the branching strategies that work in practice — trunk-based development, GitHub Flow, and when to use each.',
                'body' => <<<'MD'
GitFlow was designed for a world of scheduled releases and long-lived branches. Most teams today deploy multiple times per day. It's time to use a workflow that matches how we actually ship software.

## Why GitFlow Fails Modern Teams

GitFlow has five branch types: `main`, `develop`, `feature/*`, `release/*`, and `hotfix/*`. Each comes with merge ceremonies, and the `develop` branch becomes a dumping ground of half-finished features:

```
main ──────────────────────────────── (production)
  └── develop ─────────────────────── (integration)
        ├── feature/auth ──────────── (started 3 weeks ago)
        ├── feature/search ────────── (conflicts with auth)
        └── feature/notifications ─── (depends on auth)
```

Three weeks later, merging these branches is a full-day event. This is not sustainable with CI/CD.

## Trunk-Based Development

The simplest workflow that scales. Everyone commits to `main` (or a short-lived branch that's merged within hours):

```bash
# Start work
git checkout -b fix/login-timeout
# ... make changes, usually < 1 day of work ...
git commit -m "fix: increase session timeout to 30m"
git push -u origin fix/login-timeout
# Open PR, get review, merge, delete branch
```

Rules:
- Branches live for **hours**, not days or weeks
- All commits to `main` are deployable
- Feature flags hide incomplete work from users
- CI runs on every push

This works for teams of 2 to 200. Google, Meta, and Microsoft all use variations of trunk-based development.

## GitHub Flow

A pragmatic middle ground: `main` plus short-lived feature branches:

```
main ─── * ─── * ─── * ─── * ─── * ─── * ── (always deployable)
          \       /     \       /
           feat-1        feat-2
           (2 days)      (1 day)
```

The process:
1. Branch from `main`
2. Make commits
3. Open pull request
4. Review + CI checks
5. Merge to `main`
6. Deploy automatically

No `develop` branch. No release branches. No hotfix ceremony. Just `main` and short-lived branches.

## Practical Git Habits

### Write Useful Commit Messages

```bash
# Bad
git commit -m "fix"
git commit -m "updates"
git commit -m "WIP"

# Good
git commit -m "fix: prevent duplicate email sends on retry"
git commit -m "feat: add rate limiting to public API endpoints"
git commit -m "refactor: extract payment logic into PaymentService"
```

Use conventional commits (`feat:`, `fix:`, `refactor:`, `docs:`, `test:`). They're greppable, generate changelogs, and communicate intent.

### Interactive Rebase Before Merging

Clean up your branch history before asking for review:

```bash
git rebase -i main

# Squash WIP commits, reword unclear messages
pick abc1234 feat: add user search endpoint
squash def5678 WIP search
squash ghi9012 fix tests
reword jkl3456 add pagination
```

Your reviewers see a clean, logical history instead of your stream-of-consciousness development process.

### Use Fixup Commits During Review

When addressing review feedback, use fixup commits to keep the conversation traceable:

```bash
git commit --fixup abc1234
# After approval:
git rebase -i --autosquash main
```

The reviewer can see exactly what changed in response to their feedback. After approval, the fixup commits are squashed into the original.

## Choosing Your Workflow

| Team Size | Deploy Frequency | Recommendation |
|-----------|-----------------|----------------|
| 1-3 | Any | Trunk-based or GitHub Flow |
| 4-15 | Daily+ | GitHub Flow |
| 4-15 | Weekly | GitHub Flow |
| 15+ | Daily+ | Trunk-based with feature flags |
| Any | Scheduled releases | Consider release branches (but not full GitFlow) |

The trend is clear: shorter-lived branches, faster merges, feature flags over feature branches. Match your workflow to your deployment cadence, not to a diagram you saw in a blog post from 2010.
MD,
            ],
        ];
    }
}
