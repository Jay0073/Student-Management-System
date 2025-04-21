# Student Management System

A web-based application developed using PHP and CSS to manage student information efficiently.  
This system facilitates user registration, authentication, and role-based access for administrators, teachers, and students.  
It enables functionalities such as attendance tracking, profile management, and dashboard overviews tailored to each user role.

## Features

- **User Authentication**: Secure login and signup functionalities for all users.
- **Role-Based Dashboards**:
  - **Admin**: Access to administrative controls and overview.
  - **Teacher**: Tools for managing student attendance and records.
  - **Student**: Personal dashboard to view attendance and profile information.
- **Attendance Management**: Teachers can mark and update student attendance records.
- **Responsive Design**: User-friendly interface with responsive design elements using CSS.

## Technologies Used

- **Frontend**: HTML, CSS
- **Backend**: PHP
- **Database**: MySQL

## Folder Structure

```
Student-Management-System/
│
├── admin/              # Admin dashboard and controls
├── teacher/            # Teacher-specific pages and functionality
├── student/            # Student dashboard and features
├── config/             # Database configuration files
├── includes/           # Shared PHP components (e.g., header, footer)
├── css/                # Stylesheets for the UI
├── js/                 # JavaScript files (if any)
├── screenshots/        # Images used in README (optional)
├── assets/             # Images, icons, etc. (if applicable)
├── index.php           # Main landing page
├── login.php           # User login page
├── signup.php          # User registration page
└── README.md           # Project documentation
```


## Installation and Setup

1. **Clone the Repository**:
   ```bash
   git clone https://github.com/Jay0073/Student-Management-System.git
   ```

2. **Set Up the Environment**:
   - Ensure you have a local server environment like XAMPP or WAMP installed.
   - Place the cloned repository in the server's root directory (e.g., `htdocs` for XAMPP).

3. **Configure the Database**:
   - Create a new MySQL database (e.g., `student_management`).
   - Import the provided SQL file (if available) to set up the necessary tables.
   - Update database connection settings in the PHP files as needed.

4. **Run the Application**:
   - Start your local server.
   - Navigate to `http://localhost/Student-Management-System` in your web browser.

## Usage

- **Sign Up**: New users can register through the signup page.
- **Login**: Access the system using registered credentials.
- **Dashboard**: Upon login, users are redirected to their respective dashboards based on their roles.
- **Attendance**: Teachers can mark attendance, and students can view their attendance records.

## Contributing

Contributions are welcome! To contribute:

1. Fork the repository.
2. Create a new branch: `git checkout -b feature-name`.
3. Commit your changes: `git commit -m 'Add new feature'`.
4. Push to the branch: `git push origin feature-name`.
5. Open a pull request detailing your changes.
