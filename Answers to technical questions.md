# Answers to Technical Questions

## 1. How long did you spend on the coding test? What would you add to your solution if you had more time?

I spent approximately **2.5 hours** in total to complete the coding test:
- **30 mins:** Analyzing mockup screens (`web-view.png` and `mobile-view.png`) and extracting style tokens (colors, font scales, border-radius, margins) from the `Moodboard.xlsx` spreadsheet.
- **45 mins:** Planning the architecture and implementing the PHP backend, MySQL schema (`schema.sql`), database driver config, and the REST API (`api.php`).
- **45 mins:** Constructing the frontend layout (`index.php`, `style.css`), creating the 3-column desktop layout, the mobile accordion layout, and implementing jQuery to synchronize the active slider text and 1:1 image.
- **30 mins:** Creating the CRUD admin dashboard (`admin.php`) and developing the LocalStorage-based DB fallback feature to allow testing without configuring MySQL.

### What I would add if I had more time:
1. **Interactive Image Uploader:** Currently, users select pre-existing assets from the `images/` directory. I would implement an asynchronous image uploader in `api.php` that uses PHP's GD/Imagick extension to automatically crop and resize images to a perfect 1:1 ratio.
2. **Admin Authentication & Authorization:** Implement a secure administrator login/registration page using PHP sessions, hashed passwords (via `password_hash()`), and CSRF token protection.
3. **Advanced Slider Animations:** Utilize a slider library like Swiper.js or create custom hardware-accelerated CSS animations for a smoother horizontal sliding effect during slide transitions on both desktop and mobile viewports.
4. **API Security & Validation:** Add strict input validation (e.g., input sanitization, type checking) and rate-limiting headers to protect `api.php` endpoints.
5. **Asset Bundling:** Combine and minify CSS/JS files using Vite or Laravel Mix to optimize load times and production bundle sizes.

---

## 2. How would you track down a performance issue in production? Have you ever had to do this?

Yes, I have tracked down production performance bottlenecks in multiple projects. My systematic approach includes:

1. **System & Infrastructure Level Check:**
   - Run system monitoring utilities (e.g., `htop`, `vmstat`, `iostat`, `df -h`) to identify CPU, RAM, disk space, or disk I/O bottlenecks.
   - Inspect web server stats (Nginx/Apache status pages) to check if active connection limits have been hit.

2. **Application Performance Monitoring (APM):**
   - Use APM tools like **New Relic**, **Datadog**, or **Sentry** to isolate high TTFB (Time to First Byte), database-heavy transactions, or unhandled exceptions.
   - Utilize lightweight profiling engines like **Xdebug** or **Blackfire.io** in dev/staging mirrors to isolate CPU cycles and memory usage per function call.

3. **Database Profiling:**
   - Enable MySQL **Slow Query Log** to identify queries taking longer than a threshold (e.g., > 1s).
   - Run `EXPLAIN` on slow queries to check index utilization, joins, and scan sizes.
   - Check active database sessions via `SHOW PROCESSLIST` to find locked tables or connections.

4. **Front-End & Network Profiling:**
   - Run a Chrome DevTools Lighthouse audit to check for render-blocking scripts, large images, or slow server response times.
   - Investigate CDN cache-miss ratios and check if compression (Gzip/Brotli) is active on assets.

### Real-world Example:
In a College MIS platform, some reports and dashboards were taking significantly longer to load due to large datasets and inefficient database queries. I analyzed the slow-performing queries using MySQL profiling and EXPLAIN plans, identified missing indexes and unnecessary data fetching, and implemented query optimization along with indexing strategies. These improvements reduced report generation and dashboard load times by approximately 35–40%, resulting in a much smoother user experience.

---

## 3. Please describe yourself using JSON.

```json
## 3. Please describe yourself using JSON.

```json
{
  "name": "Abhijeet Prakash Gondchar",
  "title": "Software Developer",
  "experience_years": 3,
  "location": "Pune, India",
  "skills": {
    "frontend": ["HTML5", "CSS3", "JavaScript", "jQuery", "Bootstrap 5"], 
    "backend": ["PHP", "Laravel","Java", "Spring Boot", "MySQL"],
    "cloud_and_devops": ["AWS", "Docker", "Git", "CI/CD"],
    "architecture": ["Monolithic Applications", "Microservices"],
    "concepts": [
      "REST APIs",
      "JWT Authentication",
      "OAuth 2.0",
      "Database Optimization",
      "API Versioning"
    ]
  },
  "strengths": [
    "Problem Solving",
    "Backend Development",
    "Performance Optimization",
    "API Design",
    "Team Collaboration"
  ],
  "work_style": {
    "agile": true,
    "ownership_driven": true,
    "continuous_learner": true,
    "delivery_focused": true
  },
  "hobbies": [
    "Playing cricket",
    "Exploring new technologies and developer tools",
    "Reading about software architecture",
    "Listening to podcasts and music",
    "Traveling and exploring new places"
  ],
  "philosophy": "Build reliable solutions, keep learning, and leave the codebase better than you found it."
}

```
