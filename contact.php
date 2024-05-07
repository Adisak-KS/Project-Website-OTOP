<?php
$titlePage = "ติดต่อเรา";
require_once("db/connect.php");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once("includes/head.php") ?>
</head>

<body>

    <?php require_once("includes/navbar.php") ?>


    <!-- Single Page Header start -->
    <div class="container-fluid page-header py-5">
        <h1 class="text-center text-white display-6">ติดต่อเรา</h1>
        <ol class="breadcrumb justify-content-center mb-0">
            <li class="breadcrumb-item"><a href="index.php">หน้าแรก</a></li>
            <li class="breadcrumb-item active text-white">ติดต่อเรา</li>
        </ol>
    </div>
    <!-- Single Page Header End -->


    <!-- Contact Start -->
    <div class="container-fluid contact py-5">
        <div class="container py-5">
            <div class="p-5 bg-light rounded">
                <div class="row g-4">
                    <div class="col-12">
                        <div class="text-center mx-auto" style="max-width: 700px;">
                            <h1 class="text-primary">แผนที่การเดินทาง</h1>
                            <!-- <p class="mb-4">The contact form is currently inactive. Get a functional and working contact form with Ajax & PHP in a few minutes. Just copy and paste the files, add a little code and you're done. <a href="https://htmlcodex.com/contact-form">Download Now</a>.</p> -->
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="h-100 rounded">
                            <iframe class="w-100" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d62319.6072780725!2d99.91074397339166!3d12.517784965730533!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x30fdab967039cfcb%3A0x6e306f65b12b5972!2z4Lih4Lir4Liy4Lin4Li04LiX4Lii4Liy4Lil4Lix4Lii4LmA4LiX4LiE4LmC4LiZ4LmC4Lil4Lii4Li14Lij4Liy4LiK4Lih4LiH4LiE4Lil4Lij4Lix4LiV4LiZ4LmC4LiB4Liq4Li04LiZ4LiX4Lij4LmMIOC4p-C4tOC4l-C4ouC4suC5gOC4guC4leC4p-C4seC4h-C5hOC4geC4peC4geC4seC4h-C4p-C4pQ!5e0!3m2!1sth!2sth!4v1713442876455!5m2!1sth!2sth" width="800" height="600" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <form id="form" action="email_send.php" method="post">
                            <div class="form-group mb-3">
                                <input type="text" name="em_name" class="w-100 form-control border-0 py-3 mb-4" placeholder="ชื่อ นามสกุล ของท่าน">
                            </div>
                            <div class="form-group mb-3">
                                <input type="email" name="em_email" class="w-100 form-control border-0 py-3 mb-4" placeholder="อีเมล ของท่าน">
                            </div>
                            <div class="form-group mb-3">
                                <textarea name="em_detail" class="w-100 form-control border-0 mb-4" rows="5" cols="10" placeholder="ข้อความที่ท่านต้องการติดต่อเรา"></textarea>
                            </div>
                            <div class="form-group mb-3">
                                <button type="submit" name="btn-send-mail" class="w-100 btn form-control border-secondary py-3 bg-white text-primary">ยืนยันส่งข้อมูล</button>
                            </div>
                        </form>
                    </div>
                    <div class="col-lg-5">
                        <div class="d-flex p-4 rounded mb-4 bg-white">
                            <i class="fas fa-map-marker-alt fa-2x text-primary me-4"></i>
                            <div>
                                <h4>ที่อยู่</h4>
                                <p class="mb-2">มหาวิทยาลัยเทคโนโลยีราชมงคลรัตนโกสินทร์</p>
                                <p class="mb-2">วิทยาเขตวังไกลกังวล</p>
                            </div>
                        </div>
                        <div class="d-flex p-4 rounded mb-4 bg-white">
                            <i class="fas fa-envelope fa-2x text-primary me-4"></i>
                            <div>
                                <h4>อีเมล</h4>
                                <p class="mb-2">Adisak.General@gmail.com</p>
                            </div>
                        </div>
                        <div class="d-flex p-4 rounded bg-white">
                            <i class="fa fa-phone-alt fa-2x text-primary me-4"></i>
                            <div>
                                <h4>เบอร์ติดต่อ</h4>
                                <p class="mb-2">(+66)3 579 7491</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Contact End -->


    <!-- Footer Start -->
    <?php require_once("includes/footer.php") ?>
    <?php require_once("includes/vendor.php") ?>

    <script>
        $(function() {
            $('#form').validate({
                rules: {
                    em_name: {
                        required: true,
                        minlength: 2,
                        maxlength: 50,
                    },
                    em_email: {
                        required: true,
                        email:true,
                        minlength: 2,
                        maxlength: 50,
                    },
                    em_detail: {
                        required: true,
                        minlength: 5,
                    },
                },
                messages: {
                    em_name: {
                        required: "กรุณากรอก ชื่อ-นามสกุล ของท่าน",
                        minlength: "ต้องมีอย่างน้อย 2 ตัวอักษร",
                        maxlength: "ต้องไม่เกิน 50 ตัวอักษร"
                    },
                    em_email: {
                        required: "กรุณากรอก อีเมล ของท่าน",
                        email:"รูปแบบอีเมลไม่ถูกต้อง",
                        minlength: "ต้องมีอย่างน้อย 2 ตัวอักษร",
                        maxlength: "ต้องไม่เกิน 50 ตัวอักษร"
                    },
                    em_detail: {
                        required: "กรุณากรอก รายละเอียดที่ต้องการติดต่อ",
                        minlength: "ต้องมีอย่างน้อย 5 ตัวอักษร",
                    },
                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                }
            });
        });
    </script>

</body>

</html>
<?php require_once("includes/sweetalert2.php");