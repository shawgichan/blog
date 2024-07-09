# Yii 1.1 Blog Application

This is a simple CRUD Blog web application built using Yii 1.1 framework and MySQL.

## Features Implemented

1. **User Authentication**

   - User registration with email verification
   - User login
   - Password hashing for security
2. **Email Verification**

   - Token generation upon user registration
   - Verification process implementation
3. **Ajax Email Validation**

   - Real-time checking of email availability during registration
4. **Blog Post Management**

   - CRUD operations for blog posts
   - Restriction of CRUD operations to verified users only
5. **Blog Post Visibility**

   - Option to mark posts as public or private
   - Filtering of posts based on visibility and user authentication
6. **Like Feature**

   - Ability for users to like blog posts
7. **Search and Filter Functionality**

   - Search posts by title or content
   - Filter posts by date range and author

## Setup Instructions

1. Clone the repository:
   git clone https://github.com/shawgichan/blog.git
2. Set up the database:

- Create a new MySQL database
- Import the SQL file located in `protected/data/schema.mysql.sql`

3. Configure the database connection:

- Open `protected/config/main.php`
- Update the `db` component with your database details:
  ```php
  'db'=>array(
      'connectionString' => 'mysql:host=localhost;dbname=your_database_name',
      'emulatePrepare' => true,
      'username' => 'your_username',
      'password' => 'your_password',
      'charset' => 'utf8',
  ),
  ```

4. Set up URL rewriting:

- For Apache, ensure mod_rewrite is enabled and .htaccess is allowed
- For Nginx, configure your server block to handle pretty URLs

5. Run migrations:
   ./yiic migrate
6. Set the application in development mode:

- Open `index.php` in the root directory
- Set `defined('YII_DEBUG') or define('YII_DEBUG',true);`

## File Structure

- `protected/controllers/`
- `SiteController.php`: Handles basic site actions
- `UserController.php`: Manages user-related actions
- `BlogPostController.php`: Handles blog post CRUD operations
- `protected/models/`
- `User.php`: User model
- `BlogPost.php`: Blog post model
- `Like.php`: Like model
- `RegisterForm.php`: Registration form model
- `protected/views/`
- `layouts/`: Contains layout files
- `site/`: Views for basic site pages
- `user/`: Views for user-related pages
- `blogPost/`: Views for blog post pages

## Key Implementations

1. **User Authentication**:

- Registration: `UserController::actionRegister()`
- Login: `SiteController::actionLogin()`
- Email Verification: `UserController::actionVerify()`

2. **Blog Post Management**:

- CRUD operations: `BlogPostController`
- Visibility control: `BlogPost::model()` and `BlogPostController::actionIndex()`

3. **Ajax Email Validation**:

- JavaScript implementation in `views/user/register.php`
- Server-side handling: `UserController::actionValidateEmail()`

4. **Like Feature**:

- Like action: `BlogPostController::actionLike()`
- Like model: `Like.php`

5. **Search and Filter**:

- Implementation in `BlogPost::search()` method
- Search form in `views/blogPost/index.php`

## TODO

- Implement comments feature
- Add user profile pages
- Enhance front-end design with CSS framework

## License

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details.
