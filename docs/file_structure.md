# File Structure:

```cmd
lms/
├── public/
│   ├── index.php               # Front Controller
│   ├── .htaccess
│   └── assets/
│       ├── css/
│       ├── js/
│       └── images/
│
├── app/
│   ├── config/
│   │   └── database.php        # PDO connection
│   │
│   ├── core/
│   │   ├── App.php             # Simple Router/Dispatcher
│   │   ├── Controller.php      # Base Controller
│   │   ├── Model.php           # Base Model (CRUD)
│   │   └── Session.php         # Session wrapper
│   │
│   ├── middlewares/
│   │   └── RoleMiddleware.php
│   │
│   ├── controllers/
│   │   ├── AuthController.php
│   │   ├── Admin/
│   │   │   ├── DashboardController.php
│   │   │   ├── TeacherController.php
│   │   │   ├── StudentController.php
│   │   │   └── AccountantController.php
│   │   ├── Teacher/
│   │   │   ├── DashboardController.php
│   │   │   └── CourseController.php
│   │   ├── Student/
│   │   │   ├── DashboardController.php
│   │   │   └── FeeController.php
│   │   └── Accountant/
│   │       ├── DashboardController.php
│   │       └── InvoiceController.php
│   │
│   ├── models/
│   │   ├── User.php
│   │   ├── Admin.php
│   │   ├── Teacher.php
│   │   ├── Student.php
│   │   └── Accountant.php
│   │
│   └── views/
│       ├── layouts/
│       │   ├── admin.php
│       │   ├── teacher.php
│       │   ├── student.php
│       │   └── accountant.php
│       ├── auth/
│       │   ├── login.php
│       │   └── register.php
│       ├── admin/
│       │   ├── dashboard.php
│       │   ├── teachers.php
│       │   ├── students.php
│       │   └── accountants.php
│       ├── teacher/
│       │   ├── dashboard.php
│       │   └── courses.php
│       ├── student/
│       │   ├── dashboard.php
│       │   └── fees.php
│       └── accountant/
│           ├── dashboard.php
│           └── invoices.php
```