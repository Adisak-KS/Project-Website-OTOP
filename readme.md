# 📖 Project OTOP
___

###### แก้ไขเมื่อ : 07/05/2567
###### ผู้จัดทำ : Adisak
___

เป็นโปรเจ็คที่ทำขึ้นในการเรียนวิชา ปฏิบัติการพัฒนาโปรแกรมเว็บแบบพลวัต (Dynamic Web Programming Laboratory) (ITD 2202 - 65) ได้นำมาพัฒนาต่อจากแค่ทำได้เพียงเพิ่ม ลบ แก้ไขข้อมูลได้ ให้สามารถซื้อขายได้และเพิ่มระบบต่าง ๆ โดยได้เปลี่ยนจาก PHP(MySQLi) เป็น PHP(PDO) และการแจ้งเตือนด้วย Alert ของ JavaScript ธรรมดา เป็น Sweetalert2

___

### ⭐ ระบบภายในเว็บไซต์

        1. ผู้ใช้ระดับผู้ดูแลระบบ (Admin)
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

        2. ผู้ใช้ระดับสมาชิก (Member)
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

        3. ผู้ใช้ระดับทั่วไป (User)
            ✅ สามารถ สมัครสมาชิกได้
            ✅ สามารถค้นหาข้อมูลสินค้าได้
            ✅ สามารถดูรายละเอียดสินค้าแต่ละอย่างได้
            ✅ สามารถเลือกดูสินค้า แต่ละประเภทได้

        4. ระบบอื่น ๆ (Other)
             ✅ ตรวจสอบข้อมูลใน Form ก่อนทำใน Database
             ✅ ตรวจข้อมูลซ้ำ เช่น Username, Email, ชื่อประเภทสินค้า, ชื่อสินค้า, หมายเลขบัญชี
             ✅ มีรูป Default เมื่อเพิ่มข้อมูลใหม่
             ✅ เมื่อมีการ แก้ไข ลบ รูปภาพใหม่ รูปภาพเดิมในโฟเดอร์ uploads จะถูกลบด้วย
             ✅ มี Confirm ให้ผู้ใช้ยืนยันก่อนลบข้อมูลใน Database
             ✅ เมื่อมีการ เพิ่ม แก้ไข ลบข้อมูล สำเร็ข/ไม่สำเร็จ จะมี Sweetalert2 เพื่อแจ้งให้ผู้ใช้ได้ทราบ
             ✅ มีผู้ใช้งานระดับผู้ดูแลระบบ (Admin) เริ่มต้น จำนวน 1 บัญชี (ไม่สามารถลบได้)

___

### ✍️ ภาษาที่ใช้ในการพัฒนาระบบ

        1. HTML
        2. CSS
        3. JavaScript
        4. Bootstrap5
        5. PHP (PDO)
        6. MySQL
        6. SQL
        7. Sweetalert2
        8. jQuery Validation Plugin
        9. DataTables

___

### 🛠️ เครื่องมือที่ใช้

        1. Visual Studio Code
        2. WampServer

___

### ตัวอย่างเว็บไซต์

    1. ของผู้ดูแลระบบ (Admin)
        1.1 หน้า Login เข้าสู่ระบบ
           ![Image](https://arnaiz.com.ph/wp-content/uploads/2018/04/aaaa01.jpg)
        1.2 หน้าแรก
            [Image](preview_otop/admin/02_index.png)

        1.3 หน้าแสดงข้อมูล Member
            [Image](preview_otop/admin/03_member_Show.png)

        1.4 หน้าแสดงข้อมูล Payment
            [Image](preview_otop/admin/04_payment.png)

        1.5 หน้าแสดงข้อมูล Product
            [Image](preview_otop/admin/05_product_show.png)

        1.6 หน้าแก้ไขข้อมูล Product
        [Image](preview_otop/admin/06_product_edit.png)

        1.7 หน้าตัวอย่างการแสดง Sweetalert2
        [Image](preview_otop/admin/07_sweetalert.png)

        1.8 หน้าลบข้อมูล
        [Image](preview_otop/admin/08_delete_product.png)

        1.9 หน้าแสดงรายการสั่งซื้อ
        [Image](preview_otop/admin/09_order_show.png)

        1.10 หน้าแก้ไขสถานะรายการสั่งซื้อ
        [Image](preview_otop/admin/10_order_edit.png)

        1.11 หน้าสำหรับแจ้งเลขพัสดุ
        [Image](preview_otop/admin/11_deliverly_edit_form.png)

    2. ของสมาชิกและผู้ใช้ทั่วไป (Member & User)
        2.1 หน้าแรกของเว็บไซต์
        [Image](preview_otop/member/01_index.png)

        2.2 หน้าสมัครสมาชิก
        [Image](preview_otop/member/02_register.png)

        2.3 หน้า Login เข้าสู่ระบบ
        [Image](preview_otop/member/03_login.png)

        2.4 หน้าแสดงสินค้าทั้งหมด
        [Image](preview_otop/member/04_products_show.png)

        2.5 หน้าแสดงรายละเียดสินค้าแต่ละรายการ
        [Image](preview_otop/member/05_product_detail.png)

        2.6 หน้าติดต่อเรา
        [Image](preview_otop/member/06_contact.png)

        2.7 หน้าจัดการข้อมูลส่วนตัว
        [Image](preview_otop/member/07_my_account_setting.png)

        2.8 หน้าตะกร้าสินค้า
        [Image](preview_otop/member/08_cart_show.png)

        2.9 หน้ายืนยันรายการสินค้า และที่อยู่จัดส่ง
        [Image](preview_otop/member/09_check_out.png)

        2.10 หน้าอัปโหลดสลิปโอนเงิน (หลักฐานการชำระเงิน)
        [Image](preview_otop/member/10_upload_slip.png)

        2.11 หน้าแสดงข้อมูลประวัติสั่งซื้อสินค้า
        [Image](preview_otop/member/11_history_order.png)

        2.12 หน้ายกเลิกรายการสั่งซื้อ
        [Image](preview_otop/member/12_history_order_confirm_cancel.png)

        2.13 หน้าแสดงรายละเอียดประวัติการสั่งซื้อวินค้าแต่ละรายการ
        [Image](preview_otop/member/13_history_order_detail.png)

___

### วิธีติดตั้งเว็บไซต์

    1. นำ Database ในโฟลเดอร์ db/otop.sql ไปติดตั้งใน Wamp หรือ Xampp
    2. นำ โฟลเดอร์ otop ไปวางไว้ภายในเครื่องตนเอง
    3. หากมี Error เกี่ยวกับ Database ให้ตรวจสอบที่ db/connect.php ที่ username หรือ password

___

### วิธีเข้าใช้งาน

    1. เข้าใช้งานระดับสมาชิก(Member) โดยสมัครสมาชิกที่ http://localhost/otop/register_form.php
    2. เข้าใช้งานระดับผู้ดูแลระบบ (Admin) โดยเข้าที่ http://localhost/otop/admin/login_form.php (ต้องเข้าผ่าน Admin เริ่มต้น)

___

### ข้อมูลผู้ดูแลระบบ (Admin) เริ่มต้น
    Username : Admin1
    Password : Admin1
___
