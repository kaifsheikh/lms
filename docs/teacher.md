**Teacher ka Overview:**
Teacher system ka **Academic Core** hai. Teacher apne assigned **Courses** aur **Batches** ko complete control karta hai. Teacher hi **Course** ka content (Modules, Lessons, Recorded Lectures) banata hai, **Live Classes** ka intizam karta hai, aur **Students** ki **Assignments**, **Quizzes**, aur **Exams** check karta hai. Teacher ka kaam sirf parhana nahi, balke **Students** ki **Progress** aur **Attendance** par nazar rakhna bhi hai.

---

**1. Teacher Dashboard aur Monitoring**
Teacher ke login karte hi ek **Dashboard** khulta hai. Yeh dashboard Teacher ko us ke apne **Courses** aur **Batches** ka snapshot deta hai:

- Us ke **Total Courses** aur **Total Batches** kitne hain.
- Us ke under kitne **Total Students** hain.
- **Upcoming Live Classes** ka schedule.
- **Pending Assignments** (jin ko check karna baqi hai).
- **Pending Results** (jin ko publish karna baqi hai).
- Us ke **Courses** ki average **Attendance** aur average **Progress**.
*Is dashboard se Teacher ko 5 minute mein apni poori teaching activity ka pata chal jata hai.*

---

**2. Profile Management**
Teacher apna **Profile** complete manage kar sakta hai:

- Apni **Profile Picture**, **Bio**, **Qualification**, aur **Expertise** update karna.
- Apna **Password** change karna.
- Apni **Contact Information** (Email, Phone) update karna.
- Apni **CV/Document** re-upload karna agar zaroorat ho.

---

**3. Courses Management (Create, Edit, Draft, Publish)**
Teacher **Courses** ka complete owner hai (lekin final **Publish** admin ki approval ke baad hoti hai):

- Teacher **naya Course** bana sakta hai jis mein **Title**, **Description**, **Thumbnail**, **Category**, **Level**, **Language**, **Duration**, aur **Price** (agar paid hai) set karta hai.
- Teacher apne banaye hue **Courses** ko **Draft** (musawwada) mein rakhta hai, ya **Submit for Approval** karta hai.
- Teacher apne **Courses** ko **Edit** bhi kar sakta hai jab tak woh **Published** nahi ho jate.
- Teacher apne **Courses** ka complete **Syllabus** aur structure design karta hai.

---

**4. Modules aur Lessons Management (Course Structure)**
Teacher **Course** ko theek se arrange karne ke liye **Modules** aur **Lessons** banata hai:

- Teacher **Course** ke andar **Multiple Modules** bana sakta hai (jaise *Module 1: Basics, Module 2: Advanced*).
- Har **Module** ke andar **Lessons** add kar sakta hai.
- Har **Lesson** mein Teacher **Content** add kar sakta hai (jaise **Video**, **PDF**, **Notes**, **Documents**, **Images**, aur **External Resources**).
- Teacher har **Lesson** ki **Duration** bhi set kar sakta hai.
- Teacher chahe to **Lessons** ko **Reorder** (drag-drop) bhi kar sakta hai.

---

**5. Recorded Lectures Upload karna**
Teacher apne **Lessons** ke liye **Recorded Lectures** upload karta hai:

- Teacher **Video Files** upload kar sakta hai (system allowed formats aur size limit ke andar).
- Teacher **Video** ke saath **Description** aur **Attachments** (jaise PDF notes) bhi add kar sakta hai.
- System automatically video ki **Duration** detect kar leta hai (agar hosting platform support kare).
- Teacher chahe to pehle se upload video ko **Replace** (badal) bhi sakta hai.

---

**6. Batches Management**
Teacher apne **Courses** ke under **Batches** (jama'at) create aur manage karta hai:

- Teacher kisi **Course** ke under **Multiple Batches** bana sakta hai (jaise *Batch A - Morning*, *Batch B - Evening*).
- Teacher **Batch** mein **Students** ko add kar sakta hai (ya system automatically enrollment ke waqt add kar deta hai).
- Teacher har **Batch** ka **Schedule** (timing) set kar sakta hai.
- Teacher **Batch** ki **Maximum Students** limit bhi set kar sakta hai.

---

**7. Live Classes (Google Meet) Create karna**
Teacher **Live Classes** ka complete intizam karta hai. Teacher apna khud ka WebRTC nahi banata, balke **Google Meet** use karta hai:

- Teacher **Live Class** create karte waqt **Title**, **Course**, **Batch**, **Date**, **Start Time**, aur **End Time** set karta hai.
- Teacher apna **Google Meet Link** copy karke LMS mein paste karta hai.
- Teacher class ki **Description** bhi add kar sakta hai (jaise *"Aaj hum loops par discussion karenge"*).
- Class create hone ke baad, yeh specific **Batch** ke **Students** ko dikhti hai.
- Teacher chahe to class ko **Edit** ya **Cancel** bhi kar sakta hai.

---

**8. Attendance Monitoring**
Teacher apni **Live Classes** ki **Attendance** dekh sakta hai (jo **Google Meet API** se sync hoti hai):

- Teacher har **Live Class** ki attendance list dekh sakta hai jis mein **Student Name**, **Join Time**, **Leave Time**, aur **Duration** show hoti hai.
- System automatically **Attendance Status** (Present / Absent / Late) calculate karta hai (admin ki set ki gayi rules ke mutabiq).
- Teacher **Filters** laga sakta hai jaise *"Sirf Present students dikhao"* ya *"Sirf Absent students dikhao"*.
- Teacher kisi **Student** ki poori **Attendance History** bhi dekh sakta hai (kitni classes mein aaya, kitni mein nahi).

---

**9. Assignments, Quizzes aur Exams Create karna**
Teacher apne **Courses** ke liye **Assessments** (jaanch) ka intizam karta hai:

- **Assignments**: Teacher **Title**, **Description**, **Deadline**, **Total Marks**, aur **Attachment** (question paper) daal kar assignment publish karta hai. Teacher specific **Batch** ko assign kar sakta hai.
- **Quizzes**: Teacher **MCQ, True/False, Multiple Answer, Short Answer** type ke quizzes bana sakta hai. Teacher **Duration**, **Total Questions**, **Passing Marks**, aur **Attempts** set karta hai.
- **Exams**: Teacher **Final Exam** bana sakta hai (jaise course ke end mein). Is mein **Total Marks**, **Passing Marks**, aur **Duration** set hoti hai.

---

**10. Assignments Check karna aur Marks dena**
Teacher **Assignments** check karta hai aur **Students** ko marks deta hai:

- Teacher **Submitted Assignments** ki list dekh sakta hai.
- Teacher student ka answer **Download** kar sakta hai aur use check kar sakta hai.
- Teacher **Marks** enter karta hai aur **Feedback** (jaise *"Good effort, but improve syntax"*) likh kar student ko bhejta hai.
- **Quizzes** aur **MCQ Exams** ka result system automatically calculate kar leta hai (jis se Teacher ka time bachta hai). Lekin subjective questions ke marks Teacher manually enter kar sakta hai.
- Teacher **Results** ko publish karta hai, jis ke baad student apni dashboard par result dekh sakta hai.

---

**11. Student Progress aur Analytics dekhna**
Teacher har **Student** ki **Course Progress** track kar sakta hai:

- Teacher dekh sakta hai ke kis **Student** ne kitne **Lessons** complete kiye hain (percentage wise).
- Teacher dekh sakta hai ke kis **Student** ki **Attendance** kya hai.
- Teacher dekh sakta hai ke kis **Student** ne kitne **Assignments** submit kiye aur un ke average **Marks** kya hain.
- Teacher **Course** ke overall stats bhi dekh sakta hai, jaise *"120 Students mein se 43 ne course complete kar liya, 71 abhi progress mein hain, 6 ne chhor diya"*.
- Teacher kisi bhi **Student** ka individual **Report** bhi dekh sakta hai.

---

**12. Announcements bhejna (Specific Batch ko)**
Teacher apni **Batches** ko targeted **Announcements** bhej sakta hai:

- Teacher **Announcement** create karta hai (jaise *"Kal ki live class subah 8 baje hogi"*).
- Teacher is announcement ko kisi specific **Batch** ke liye send karta hai.
- Sirf us specific **Batch** ke **Students** ko yeh **Notification** (in-app aur email) milegi.

---

**13. Messages / Communication (Students se baat karna)**
Teacher **Students** se direct communicate kar sakta hai:

- Teacher kisi specific **Student** ko **Message** bhej sakta hai (jaise assignment ke baare mein puchna).
- Student bhi Teacher ko message kar sakta hai.
- Yeh messaging system course/batch ke context mein rehti hai (taake Teacher ko pata ho ke kis course ki baat ho rahi hai).

---

**14. Reviews aur Feedback dekhna**
Course complete hone ke baad **Students** Teacher ko **Rating** aur **Feedback** dete hain:

- Teacher apni **Reviews** dekh sakta hai (stars aur comments).
- Teacher yeh dekh sakta hai ke students us ki teaching style, course content, aur live classes ke baare mein kya keh rahe hain.
- Teacher is feedback ko apni future teaching ko improve karne ke liye use kar sakta hai.

---

**15. Access Rights (Teacher Permissions)**
Teacher ki permissions strictly us ke apne **Courses** aur **Batches** tak limited hain:

- Teacher sirf apne **Courses** ko edit/delete kar sakta hai, doosre Teacher ke **Courses** ko nahi.
- Teacher sirf apne **Batches** ke **Students** ki **Attendance** aur **Progress** dekh sakta hai.
- Teacher **Admin** ya **Accountant** ke financial modules ko access nahi kar sakta.
- Teacher kisi bhi doosre Teacher ki private **Assignments** ya **Quizzes** nahi dekh sakta.

---

**Mukhtasir Khulasa (Teacher Role Summary):**
Teacher ki asli taaqat yeh hai ke woh ek sath **Content Creator + Instructor + Evaluator + Mentor** hai.

- **Content Creator**: **Courses, Modules, Lessons, aur Recorded Lectures** banata hai.
- **Instructor**: **Live Classes** (Google Meet) conduct karta hai aur students ko parhata hai.
- **Evaluator**: **Assignments, Quizzes, aur Exams** check karke **Marks** deta hai.
- **Mentor**: **Students** ki **Attendance** aur **Progress** monitor karta hai, aur unhe **Announcements** aur **Messages** ke zariye guide karta hai.