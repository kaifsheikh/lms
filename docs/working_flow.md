# LMS - Working Flow

## Project Overview
Yeh ek **Learning Management System (LMS)** hai jo admin, teacher aur students ko connect karta hai. Ismein courses, batches, quizzes, attendance aur online classes ka complete management hai.

---

## Technology Stack
| Technology | Usage |
|------------|-------|
| **PHP** | Backend logic (Procedural + OOP Models) |
| **MySQL (mysqli)** | Database |
| **Tailwind CSS** | Frontend styling |
| **JavaScript** | Timer, sidebar toggle, search |
| **XAMPP** | Local server |

---

## Users / Roles

### 1. Admin
Admin system ka full control rakhta hai. Woh teachers aur students ko register karta hai, approve karta hai, courses aur batches banata hai.

**Admin ke Kaam:**

| Feature | Description |
|---------|-------------|
| **Dashboard** | Summary dekhta hai - total teachers, students, batches, quizzes, online classes, attendance |
| **Teacher Approval** | Naye teachers ko approve ya reject karta hai (pending -> approved/rejected) |
| **Batch Approval** | Teachers ki batches ko approve karta hai |
| **Create Batch** | Naya batch banata hai, teacher assign karta hai, student ko batch mein dalta hai |
| **Transfer Student** | Student ko ek batch se doosre batch mein transfer karta hai |
| **Remove Student** | Student ko batch se nikalta hai |
| **Delete Batch** | Batch ko delete karta hai |
| **Course Management** | Naya course banata hai (name, duration, fees, skill level, schedule) |
| **Edit Course** | Course ki details update karta hai |
| **Delete Course** | Course ko delete karta hai |
| **Student Registration** | 4-step form se student register karta hai (personal info, login details, course, documents) |
| **Student Management** | Students ki list dekhta hai, status change karta hai, teacher assign karta hai |
| **Edit Student** | Student ki details update karta hai |
| **Delete Student** | Student ko delete karta hai (files bhi delete hoti hain) |
| **Attendance Progress** | Batch-wise ya student-wise attendance dekhta hai |

---

### 2. Teacher
Teacher apne batches, students, quizzes aur attendance ka management karta hai.

**Teacher ke Kaam:**

| Feature | Description |
|---------|-------------|
| **Dashboard** | Apna summary dekhta hai - batches, students, quizzes, classes, attendance |
| **My Batches** | Apni saari batches dekhta hai unke students ke saath |
| **All Students** | Apne saare assigned students dekhta hai |
| **Search Student** | Student ID se search karke details dekhta hai (course progress, end date) |
| **Create Quiz** | Naya quiz banata hai (title, description, due date, timer, passing marks, batch select) |
| **Manage Questions** | Quiz mein questions add karta hai (MCQ format - question + options + correct answer) |
| **Edit Quiz** | Quiz ki details update karta hai |
| **Start Quiz** | Quiz ko draft se active karta hai (students ko dikhta hai) |
| **Delete Quiz** | Quiz ko delete karta hai |
| **Quiz Results** | Students ke quiz results dekhta hai (marks, percentage, pass/fail) |
| **Retake** | Failed student ki attempt delete karta hai taake woh dobara le sake |
| **Quiz History** | Saari quiz attempts ka permanent record dekhta hai |
| **Select Attendance** | Batch aur date select karta hai attendance mark karne ke liye |
| **Mark Attendance** | Students ki attendance mark karta hai (present/absent/late/leave) |
| **Attendance Report** | Kisi bhi batch + date ka attendance report dekhta hai |
| **Create Class** | Online class banata hai (title, meet link, batch, time, token) |
| **Class Report** | Class attendance report dekhta hai |
| **Delete Class** | Class ko delete karta hai |

---

### 3. Student
Student apne quizzes leta hai, attendance dekhta hai, classes join karta hai.

**Student ke Kaam:**

| Feature | Description |
|---------|-------------|
| **Dashboard** | Summary dekhta hai - quizzes, classes, attendance percentage, recent results |
| **Upcoming Quizzes** | Active quizzes dekhta hai jo abhi attempt nahi ki |
| **Take Quiz** | Quiz deta hai (timer ke saath, MCQ format) |
| **Results** | Apne saari quiz results dekhta hai (marks, percentage, pass/fail) |
| **My Attendance** | Apni attendance dekhta hai (present, absent, late, leave counts + percentage) |
| **My Classes** | Upcoming classes dekhta hai, token se attendance mark karta hai, meet link join karta hai |

---

## Complete Working Flow

### Step 1: System Setup
```
Admin System Mein登录 -> Dashboard Dekhta Hai
```

### Step 2: Teacher Registration
```
Teacher Register -> Status: Pending -> Admin Approve -> Teacher Login
```

### Step 3: Course Creation
```
Admin -> Course Management -> Create Course (name, duration, fees, schedule)
```

### Step 4: Student Registration
```
Admin -> Student Register (4 steps) -> Personal Info -> Login Details -> Course + Teacher -> Documents -> Status: Active
```

### Step 5: Batch Creation
```
Admin -> Create Batch -> Select Teacher -> Add Students -> Batch Approved
```

### Step 6: Quiz System
```
Teacher -> Create Quiz -> Add Questions (MCQ) -> Start Quiz (Draft -> Active)
                                                          |
Student -> Upcoming Quizzes -> Take Quiz -> Submit -> Results
                                                          |
Teacher -> Quiz Results -> Pass/Fail Statistics -> Retake (if failed)
```

### Step 7: Attendance System
```
Teacher -> Select Batch + Date -> Mark Attendance (Present/Absent/Late/Leave)
                                                          |
Student -> My Attendance -> View Summary + Percentage
                                                          |
Admin -> Attendance Progress -> Batch-wise / Student-wise Report
```

### Step 8: Online Classes
```
Teacher -> Create Class (Title, Meet Link, Batch, Time) -> Get Token
                                                          |
Student -> My Classes -> Enter Token -> Join Meeting -> Attendance Auto-Marked
                                                          |
Teacher -> Class Report -> View Who Attended
```

---

## Database Tables

| Table | Purpose |
|-------|---------|
| `users` | Admin, Teacher, Accountant accounts |
| `students` | Student records (separate from users) |
| `courses` | Course details |
| `batches` | Batch records (teacher + status) |
| `batch_students` | Many-to-many: batch <-> student |
| `quizzes` | Quiz records |
| `questions` | Quiz questions |
| `question_options` | MCQ options (with correct answer) |
| `quiz_attempts` | Student quiz attempts |
| `quiz_attempt_history` | Permanent quiz history |
| `attendance` | Daily attendance records |
| `online_classes` | Online class records |
| `class_attendance` | Class attendance (via token) |

---

## Security Features

| Feature | Description |
|---------|-------------|
| **CSRF Protection** | Har POST form mein token verify hota hai |
| **Role-Based Access** | Har controller mein role check hota hai |
| **Session Security** | Login pe session regenerate hota hai |
| **Password Hashing** | passwords bcrypt se hash hote hain |
| **Input Sanitization** | Saari output htmlspecialchars se safe hai |
| **Ownership Check** | Teacher sirf apne batches/quizzes manage kar sakta hai |
| **File Upload Validation** | Sirf images allowed (2MB limit) |

---

## Key Rules

1. **Students khud register nahi kar sakte** - sirf Admin register karta hai
2. **Teachers ko Admin approve kare** tabhi login kar sakte hain
3. **Teacher ki batch ko Admin approve kare** tabhi students ko dikhti hai
4. **Student ek time mein sirf ek batch mein** hota hai
5. **Quiz pehle draft mein hota hai** - teacher ko start karna padta hai
6. **Student ek quiz sirf ek baar de sakta hai** - retake ke liye teacher delete kare
7. **Attendance ek din mein ek baar** mark hoti hai
8. **Class attendance ke liye token** chahiye jo teacher deta hai
