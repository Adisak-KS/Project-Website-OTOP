# 📖 Project OTOP (เว็บไซต์ซื้อขายสินค้า OTOP)

###### ✍️แก้ไขเมื่อ : 07/05/2567
###### 👨‍💻ผู้จัดทำ : Adisak
___

เป็นโปรเจ็คที่ทำขึ้นในการเรียนวิชา ปฏิบัติการพัฒนาโปรแกรมเว็บแบบพลวัต (Dynamic Web Programming Laboratory) (ITD 2202 - 65) ได้นำมาพัฒนาต่อจากแค่ทำได้เพียงเพิ่ม ลบ แก้ไขข้อมูลได้ ให้สามารถซื้อขายได้และเพิ่มระบบต่าง ๆ โดยได้เปลี่ยนจาก PHP(MySQLi) เป็น PHP(PDO) และการแจ้งเตือนด้วย Alert ของ JavaScript ธรรมดา เป็น Sweetalert2 สามารถดูตัวอย่างเว็บไซต์ได้ [ที่นี่](https://github.com/Adisak-KS/Project-Website-OTOP/tree/main/preview_otop)

___ 

### ⭐ ระบบภายในเว็บไซต์

        1. 👮ผู้ใช้ระดับผู้ดูแลระบบ (Admin)
            ✅ สามารถ login เข้าสู่ระบบได้
            ✅ สามารถแก้ไขข้อมูลส่วนตัวได้
            ✅ สามารถแก้ไขข้อมูลบัญชี เช่น Username และ Email ตนเองได้
            ✅ สามารถแก้ไข Password ตนเองได้
            ✅ สามารถ เพิ่ม แก้ไข ลบ ข้อมูลผู้ดูแลระบบได้
            ✅ สามารถ เพิ่ม แก้ไข ลบ ข้อมูลสมาชิกได้
            ✅ สามารถ เพิ่ม แก้ไข ลบ ข้อมูลประเภทสินค้าได้
            ✅ สามารถ เพิ่ม แก้ไข ลบ ข้อมูลสินค้าได้
            ✅ สามารถ เพิ่ม แก้ไข ลบ ข้อมูลช่องทางชำระเงินได้
            ✅ สามารถ จัดการข้อมูลคำสั่งซื้อ จากสมาชิก (Member) ได้
            ✅ สามารถ จัดการข้อมูลรายการสินค้ารอจัดส่ง ของสมาชิก (Member) ได้
            ✅ สามารถ จัดการข้อมูลสินค้า ที่เหลือน้อยกว่าหรือเท่ากับ 5 ชิ้นได้
            ✅ สามารถ ตรวจสอบรายงานยอดขายสินค้าได้ (สินค้าที่จัดส่งแล้ว)
            ✅ สามารถ ตรวจสอบข้อมูลที่ติดต่อมาได้
            ✅ สามารถ Logout ออกจากระบบได้

        2. 🙎‍♂️ผู้ใช้ระดับสมาชิก (Member)
            ✅ สามารถ login เข้าสู่ระบบได้
            ✅ สามารถแก้ไขข้อมูลส่วนตัวได้
            ✅ สามารถแก้ไขข้อมูลบัญชี เช่น Username และ Email ตนเองได้
            ✅ สามารถแก้ไข Password ตนเองได้
            ✅ สามารถตรวจสอบประวัติการสั่งซื้อสินค้า แต่ละรายการได้
            ✅ สามารถค้นหาข้อมูลสินค้าได้
            ✅ สามารถดูรายละเอียดสินค้าแต่ละอย่างได้
            ✅ สามารถเลือกดูสินค้า แต่ละประเภทได้
            ✅ สามารเพิ่มสินค้าเข้าตะกร้าได้
            ✅ สามารชำระเงิน และอัปโหลดสลิป หลักฐานการชำระเงินได้
            ✅ สามารถ Logout ออกจากระบบได้

        3. 👥ผู้ใช้ระดับทั่วไป (User)
            ✅ สามารถ สมัครสมาชิกได้
            ✅ สามารถค้นหาข้อมูลสินค้าได้
            ✅ สามารถดูรายละเอียดสินค้าแต่ละอย่างได้
            ✅ สามารถเลือกดูสินค้า แต่ละประเภทได้

        4. 🪂ระบบอื่น ๆ (Other)
             ✅ ตรวจสอบข้อมูลใน Form ก่อนทำใน Database
             ✅ ตรวจข้อมูลซ้ำ เช่น Username, Email, ชื่อประเภทสินค้า, ชื่อสินค้า, หมายเลขบัญชี
             ✅ มีรูป Default เมื่อเพิ่มข้อมูลใหม่
             ✅ เมื่อมีการ แก้ไข ลบ รูปภาพใหม่ รูปภาพเดิมในโฟเดอร์ uploads จะถูกลบด้วย
             ✅ มี Confirm ให้ผู้ใช้ยืนยันก่อนลบข้อมูลใน Database
             ✅ เมื่อมีการ เพิ่ม แก้ไข ลบข้อมูล สำเร็จ/ไม่สำเร็จ จะมี Sweetalert2 เพื่อแจ้งให้ผู้ใช้ได้ทราบ
             ✅ มีผู้ใช้งานระดับผู้ดูแลระบบ (Admin) เริ่มต้น จำนวน 1 บัญชี (ไม่สามารถลบได้)

___

### ✍️ ภาษาที่ใช้ในการพัฒนาระบบ

        1. HTML
        2. CSS
        3. JavaScript
        4. Bootstrap5
        5. PHP (PDO)
        6. MySQL
        7. Sweetalert2
        8. jQuery Validation Plugin
        9. DataTables

___

### 🛠️ เครื่องมือที่ใช้

        1. Visual Studio Code
        2. WampServer

___

### 📥วิธีติดตั้งเว็บไซต์

    1. นำ Database ในโฟลเดอร์ db/otop.sql ไปติดตั้งใน Wamp หรือ Xampp
    2. นำ โฟลเดอร์ otop ไปวางไว้ภายในเครื่องตนเอง
    3. หากมี Error เกี่ยวกับ Database ให้ตรวจสอบที่ db/connect.php ที่ username หรือ password

___

### 🕯️วิธีเข้าใช้งาน

    1. เข้าใช้งานระดับสมาชิก(Member) โดยสมัครสมาชิกที่ http://localhost/otop/register_form.php
    2. เข้าใช้งานระดับผู้ดูแลระบบ (Admin) โดยเข้าที่ http://localhost/otop/admin/login_form.php (ต้องเข้าผ่าน Admin เริ่มต้น)

___

### 📑ข้อมูลผู้ดูแลระบบ (Admin) เริ่มต้น
    Username : Admin1
    Password : Admin1
___

### 💻 ตัวอย่างเว็บไซต์

**ของผู้ดูแลระบบ (Admin)**
1. หน้า Login เข้าสู่ระบบ
   
![index](https://github.com/Adisak-KS/Project-Website-OTOP/blob/main/preview_otop/admin/01_login_admin.png)

2. หน้าแรกของผู้ดูแลระบบ
   
![index](https://github.com/Adisak-KS/Project-Website-OTOP/blob/main/preview_otop/admin/02_index.png)


3. หน้าแสดงข้อมูลสมาชิก
   
![index](https://github.com/Adisak-KS/Project-Website-OTOP/blob/main/preview_otop/admin/03_member_Show.png)


4. หน้าแสดงช่องทางชำระเงิน
   
![index](https://github.com/Adisak-KS/Project-Website-OTOP/blob/main/preview_otop/admin/04_payment.png)


5. หน้าแสดงข้อมูลสินค้า
   
![index](https://github.com/Adisak-KS/Project-Website-OTOP/blob/main/preview_otop/admin/05_product_show.png)

6. หน้าแก้ไขข้อมูลสินค้า
   
![index](https://github.com/Adisak-KS/Project-Website-OTOP/blob/main/preview_otop/admin/06_product_edit.png)

7. Sweetalert2 เมื่อเพิ่ม ลบ แก้ไข สำเร็จ/ไม่สำเร็จ
   
![index](https://github.com/Adisak-KS/Project-Website-OTOP/blob/main/preview_otop/admin/07_sweetalert.png)

8. หน้าลบข้อมูลสินค้า
   
![index](https://github.com/Adisak-KS/Project-Website-OTOP/blob/main/preview_otop/admin/08_delete_product.png)

9. หน้าแสดงรายการสั่งซื้อ
   
![index](https://github.com/Adisak-KS/Project-Website-OTOP/blob/main/preview_otop/admin/09_order_show.png)

10. หน้าตรวจสอบและอัปเดทรายการสั่งซื้อ
   
![index](https://github.com/Adisak-KS/Project-Website-OTOP/blob/main/preview_otop/admin/10_order_edit.png)

11. หน้าแสดงรายการที่รอจัดส่ง
   
![index](https://github.com/Adisak-KS/Project-Website-OTOP/blob/main/preview_otop/admin/11_deliverly_edit_form.png)


___

**ของสมาชิก & ผู้ใช้ทั่วไป(Member & User)**

1. หน้าแรกของเว็บไซต์
![index](https://github.com/Adisak-KS/Project-Website-OTOP/blob/main/preview_otop/member/01_index.png)

2. หน้าสมัครสมาชิก

![index](https://github.com/Adisak-KS/Project-Website-OTOP/blob/main/preview_otop/member/02_register.png)

3. หน้า Login เข้าสู่ระบบ

![index](https://github.com/Adisak-KS/Project-Website-OTOP/blob/main/preview_otop/member/03_login.png)

4. หน้าแสดงสินค้าทั้งหมด

![index](https://github.com/Adisak-KS/Project-Website-OTOP/blob/main/preview_otop/member/04_products_show.png)

5. หน้าแสดงรายละเอียดสินค้าแต่ละรายการ

![index](https://github.com/Adisak-KS/Project-Website-OTOP/blob/main/preview_otop/member/05_product_detail.png)

6. หน้าติดต่อเรา
![index](https://github.com/Adisak-KS/Project-Website-OTOP/blob/main/preview_otop/member/06_contact.png)

7. หน้าแสดงสินค้าทั้งหมด

![index](https://github.com/Adisak-KS/Project-Website-OTOP/blob/main/preview_otop/member/05_product_detail.png)

8. หน้าจัดการบัญชีของฉัน

![index](https://github.com/Adisak-KS/Project-Website-OTOP/blob/main/preview_otop/member/07_my_account_setting.png)

9. หน้าตะกร้าสินค้า

![index](https://github.com/Adisak-KS/Project-Website-OTOP/blob/main/preview_otop/member/08_cart_show.png)

10. หน้าอัปโหลดหลักฐานการชำระเงิน

![index](https://github.com/Adisak-KS/Project-Website-OTOP/blob/main/preview_otop/member/10_upload_slip.png)

11. หน้าแสดงประวัติสั่งซื้อสินค้า

![index](https://github.com/Adisak-KS/Project-Website-OTOP/blob/main/preview_otop/member/11_history_order.png)

12. หน้า Confirm ยกเลิกรายการสั่งซื้อ

![index](https://github.com/Adisak-KS/Project-Website-OTOP/blob/main/preview_otop/member/12_history_order_confirm_cancel.png)

13. หน้าแสดงรายละเอียดประวัติการสั่งซื้อแต่ละรายการ

![index](https://github.com/Adisak-KS/Project-Website-OTOP/blob/main/preview_otop/member/13_history_order_detail.png)
