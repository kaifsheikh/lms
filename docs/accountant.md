**Accountant ka Overview:**  
Accountant system ka **Financial Manager** hai. Is ka main kaam **Students ki Fees, Payments, Transactions, Invoices, aur Financial Records** ko handle karna hai. Accountant yeh sab kuch LMS ke andar hi karega. Admin ko in sab modules par **Supervisory Access** hoga, matlab Admin dekh sakta hai aur agar zaroorat ho toh kisi bhi transaction ko override/correct bhi kar sakta hai.

---

**1. Student Fee Management (Paid / Unpaid / Defaulters)**  
Accountant ka sab se ahem kaam yeh hai ke woh har **Student** ki fee record rakhe.

- Accountant har **Student** ki detail dekh sakta hai ke us ne **Current Month** ki fee di hai ya nahi.
- Accountant ko ek **Filter** milta hai jahan woh dekh sakta hai:
  - **Paid Students** (jinho ne iss month ki fee jama kar di).
  - **Unpaid Students** (jin ki fee baqi hai).
  - **Defaulters** (jin ki 2 ya zyada mahine ki fee baqi ho).
- Accountant har **Student** ke khilaf **Manual Entry** bhi daal sakta hai agar student ne cash diya hai (offline payment).
- Accountant **Fee Reminders** bhej sakta hai (email/in-app) un students ko jin ki fee baqi hai.
- Accountant **Month-wise Fee Reports** dekh sakta hai, jaise *"August 2026 mein kitne students ne fee di, kitne ne nahi di"*.

---

**2. Payment aur Transaction Management**  
Accountant poori system ki **Transactions** (len-den) ko monitor aur manage karta hai.

- Accountant har **Transaction** ki detail dekh sakta hai, jaise:
  - **Student Name**
  - **Course Name**
  - **Amount** (kitne paise aaye)
  - **Payment Method** (Credit Card, Bank Transfer, JazzCash, etc.)
  - **Date & Time**
  - **Status** (Pending, Paid, Failed, Cancelled).
- Accountant kisi bhi **Pending Transaction** ko manually **Paid** mark kar sakta hai agar payment bank mein aa gayi ho lekin system automatically update na hui ho.
- Accountant **Search aur Filter** kar sakta hai, jaise *"mujhe Ahmed ki tamam transactions dikhao"* ya *"mujhe Failed transactions dikhao"*.

---

**3. Financial Reports aur Analytics**  
Accountant ke liye **Reports** sab se powerful tool hai. Woh kisi bhi financial cheez ki detailed report generate kar sakta hai:

- **Monthly Revenue Report** (iss mahine kitni aamdani hui).
- **Student Fee Collection Report** (kis student ne kab fee di).
- **Course-wise Revenue Report** (kis course se kitna paisa aaya).
- **Transaction History Report** (tamam transactions ki list).
- **Defaulters Report** (jin students ki fee baqi hai).

Accountant in sab reports ko **PDF, Excel, ya CSV** mein download kar sakta hai, taake woh management ko present kar sake ya record rakhe.

---

**4. Invoicing (Bill / Receipt) Generate karna**  
Accountant har student ko **Invoice** (fee ka bill) ya **Receipt** (payment ki slip) generate kar sakta hai.

- Jab student fee deta hai, toh Accountant uske khilaf **Official Receipt** generate kar sakta hai jis mein **Transaction ID**, **Amount**, aur **Date** ho.
- Accountant receipt student ko email bhi kar sakta hai.
- Accountant kisi bhi purani receipt ko dobara download kar sakta hai agar student ne kho di ho.

---

**5. Access Rights (Accountant vs Admin)**

- **Accountant**: Is ko **Financial Module** ka complete access hoga. Accountant **Add, Edit, aur Update** kar sakta hai fees, transactions, aur payments mein. Accountant reports bana sakta hai. (Refunds aur Teacher Payouts is ke scope mein nahi hain).
  
- **Admin**: Admin ko **Supervisory Access** hoga. Admin har woh cheez dekh sakta hai jo Accountant dekh/kar sakta hai. Is ke alawa:
  - Admin **Accountant ke actions ko Audit Logs** mein dekh sakta hai (jaise *"Accountant Ali ne Student #12 ki fee update ki"*).
  - Agar Accountant koi ghalti kar de, toh Admin us transaction ko **Override** (wapas theek) kar sakta hai.
  - Admin **Accountant ki permissions** bhi change kar sakta hai (jaise agar zaroorat ho toh Accountant ko kisi specific course ki fees dekhne se rok de).

---

**Mukhtasir Khulasa (Accountant Role Summary):**

- **Accountant** = System ka **Cashier aur Finance Manager**.
- Is ka kaam hai: **Fees collect karna, defaulters track karna, transactions manage karna, invoices generate karna, aur financial reports banana**.
- **Admin** = **Owner / Supervisor**. Admin Accountant ke har kaam ko dekh sakta hai, audit kar sakta hai, aur agar zaroorat ho toh kisi bhi financial entry ko manually theek (override) kar sakta hai.