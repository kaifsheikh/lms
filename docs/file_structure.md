# File Structure:

```cmd
lms/
├── .gitignore
├── index.php                  # Entry point
├── config.php                 # Database configuration
├── package.json               # Node.js dependencies
├── package-lock.json
├── tailwind.config.js         # Tailwind CSS config
├── postcss.config.js          # PostCSS config
│
├── accounts/                  # Authentication module
│   ├── controller/
│   │   ├── login.php
│   │   ├── logout.php
│   │   └── register.php
│   └── view/
│       ├── login.php
│       └── register.php
│
├── admin/                     # Admin module
│   ├── controller/
│   │   ├── dashboard.php
│   │   ├── attendance_progress.php
│   │   ├── course_management.php
│   │   ├── courses_list.php
│   │   ├── student/
│   │   │   ├── approval.php
│   │   │   ├── delete.php
│   │   │   ├── edit.php
│   │   │   ├── manage.php
│   │   │   └── register.php
│   │   └── teacher/
│   │       ├── approval.php
│   │       └── batch_approval.php
│   └── view/
│       ├── dashboard.php
│       ├── attendance_progress.php
│       ├── course_management.php
│       ├── courses_list.php
│       ├── student/
│       │   ├── approval.php
│       │   ├── edit.php
│       │   ├── manage.php
│       │   └── register.php
│       └── teacher/
│           ├── approval.php
│           └── batch_approval.php
│
├── teacher/                   # Teacher module
│   ├── controller/
│   │   ├── dashboard.php
│   │   ├── attendance.php
│   │   ├── attendance_mark.php
│   │   ├── attendance_report.php
│   │   ├── attendance_save.php
│   │   ├── manage_classes.php
│   │   ├── class_report.php
│   │   ├── my_batches.php
│   │   ├── manage_questions.php
│   │   ├── quiz_management.php
│   │   ├── quiz_history.php
│   │   ├── quiz_results.php
│   │   ├── edit_quiz.php
│   │   ├── all_students.php
│   │   └── search_student.php
│   └── view/
│       ├── dashboard.php
│       ├── attendance.php
│       ├── attendance_mark.php
│       ├── attendance_report.php
│       ├── manage_classes.php
│       ├── class_report.php
│       ├── create_batch.php
│       ├── my_batches.php
│       ├── manage_questions.php
│       ├── quiz_management.php
│       ├── quiz_history.php
│       ├── quiz_results.php
│       ├── edit_quiz.php
│       ├── all_students.php
│       └── search_student.php
│
├── student/                   # Student module
│   ├── controller/
│   │   ├── dashboard.php
│   │   ├── my_classes.php
│   │   ├── my_attendance.php
│   │   ├── quizzes.php
│   │   ├── take_quiz.php
│   │   ├── submit_quiz.php
│   │   └── results.php
│   └── view/
│       ├── dashboard.php
│       ├── my_classes.php
│       ├── my_attendance.php
│       ├── quizzes.php
│       ├── take_quiz.php
│       └── results.php
│
├── includes/                  # Common includes
│   ├── autoload.php
│   ├── db.php
│   ├── header.php
│   ├── footer.php
│   └── session.php
│
├── models/                    # Database models
│   ├── User.php
│   ├── Student.php
│   ├── Course.php
│   ├── Batch.php
│   ├── Attendance.php
│   ├── Quiz.php
│   └── OnlineClass.php
│
├── assets/                    # Static assets
│   ├── src/
│   │   └── input.css
│   └── uploads/
│       └── students/
│
├── css/                       # CSS files
│   └── tailwind.css
│
├── docs/                      # Documentation
│   ├── accountant.md
│   ├── admin.md
│   ├── file_structure.md
│   └── teacher.md
│
└── node_modules/              # Node.js modules
```

## View Files Summary

| Module | Folder | Files Count |
|--------|--------|-------------|
| Accounts | accounts/view/ | 2 files |
| Admin | admin/view/ | 4 files |
| Admin - Student | admin/view/student/ | 4 files |
| Admin - Teacher | admin/view/teacher/ | 2 files |
| Student | student/view/ | 6 files |
| Teacher | teacher/view/ | 15 files |
| **Total** | | **33 view files** |
