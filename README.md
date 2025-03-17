# 📅 Laravel Post Scheduling API

This project is a Laravel-based API that lets you schedule posts for platforms like Facebook, Twitter, Instagram, and LinkedIn. It uses Laravel Jobs & Queues for automatic publishing.

## 🚀 Features

* **Schedule Posts:** Create posts with title, content, image, platform selection, and scheduled date/time.
* **Automatic Publishing:** Posts publish automatically using Laravel Queues.
* **Platform Management:** Toggle active platforms.
* **API Endpoints:** Create, retrieve, update, and delete posts.
* **Validation:** Platform-specific validation (e.g., character limits).
* **Background Processing:** Laravel Queues for smooth processing.
* **Scalability:** Designed for high volumes of posts and platforms.

## 📦 Installation

1.  **Clone:** `git clone https://github.com/Hamody2000/Content-Scheduler.git && cd Content-Scheduler`
2.  **Install:** `composer install`
3.  **Env Setup:** `cp .env.example .env && php artisan key:generate`
4.  **Migrate & Seed:** `php artisan migrate --seed`
5.  **Queue Worker:** `php artisan queue:work`
6.  **Start Server:** `php artisan serve`

## 🔑 Authentication

* **Register:** `POST /api/register`
    * Body: `{"name": "name", "email": "email", "password": "password", "password_confirmation": "password"}`
    * Response: User details and token.
* **Login:** `POST /api/login`
    * Body: `{"email": "email", "password": "password"}`
    * Response: Token.
* **Logout:** `POST /api/logout`
    * Headers: `Authorization: Bearer {token}`

## 📝 Posts API

* **Create Post:** `POST /api/posts`
    * Headers: `Authorization: Bearer {token}`
    * Body: `{"title": "title", "content": "content", "image_url": "url", "scheduled_time": "2025-03-20 15:00:00", "platforms": [1]}`
* **Update Post:** `PUT /api/posts/{post_id}`
    * Headers: `Authorization: Bearer {token}`
    * Body: `{"title": "title", "content": "content", "image_url": "url", "scheduled_time": "2025-03-21 16:00:00", "status": "scheduled"}`
* **Get Posts:** `GET /api/posts`
    * Headers: `Authorization: Bearer {token}`
    * Query: `status=draft` (optional)
* **Get User Posts:** `GET /api/user/posts`
    * Headers: `Authorization: Bearer {token}`
* **Delete Post:** `DELETE /api/posts/{post_id}`
    * Headers: `Authorization: Bearer {token}`

**Example Create Post Request:**

```http
POST [http://127.0.0.1:8000/api/posts]
Headers:
    Content-Type: application/json
    Authorization: Bearer {token}
Body:
{
    "title": "Test Post",
    "content": "This is a scheduled post",
    "image_url": null,
    "scheduled_time": "2025-03-14 12:00:00",
    "platforms": [1, 2]
}

📤 Platforms API
List Platforms: GET /api/platforms
Headers: Authorization: Bearer {token}
Toggle Platform: PATCH /api/platforms/{platform_id}/toggle
Headers: Authorization: Bearer {token}

✅ Key Trade-offs
Laravel Jobs & Queues: Background processing, fault tolerance.
Status Column: Tracks post lifecycle (draft, scheduled, published, failed).
scheduled_time: Precise scheduling, timezone support.

🌐 API Endpoints Summary
GET /api/posts: Retrieve user posts (filters: status, date).
POST /api/posts: Schedule a new post.
GET /api/posts/{id}: Get post details by ID.
PUT /api/posts/{id}: Update a post.
DELETE /api/posts/{id}: Delete a post.
GET /api/platforms: List platforms.
PATCH /api/platforms/{platform_id}/toggle: Toggle platform status.



Core Features
Post Scheduling:
Users can create posts with a title, content, optional image, and scheduled time.
Posts can be scheduled for future publication.

Platform Integration:
Posts can be scheduled for multiple platforms (e.g., Twitter, Instagram, LinkedIn, Facebook).
Platform-specific validation ensures posts meet platform requirements (e.g., character limits).

Automatic Publishing:
A Laravel job (PublishScheduledPosts) runs every minute to check for due posts and publish them.
The job updates the post status to published and logs the process.
