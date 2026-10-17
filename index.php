
<?php
$nama = '';
$kelas = '';
$jurusan = '';
$errors = [];
$isSubmitted = $_SERVER['REQUEST_METHOD'] === 'POST';

if ($isSubmitted) {
    $nama = isset($_POST['nama']) && is_string($_POST['nama'])
        ? trim($_POST['nama']) : '';

    $kelas = isset($_POST['kelas']) && is_string($_POST['kelas'])
        ? trim($_POST['kelas']) : '';

    $jurusan = isset($_POST['jurusan']) && is_string($_POST['jurusan'])
        ? trim($_POST['jurusan']) : '';

    if ($nama === '') {
        $errors['nama'] = 'Nama lengkap wajib diisi.';
    }

    if ($kelas === '') {
        $errors['kelas'] = 'Kelas wajib diisi.';
    }

    if ($jurusan === '') {
        $errors['jurusan'] = 'Jurusan wajib diisi.';
    }
}

function e($value)
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Identitas Siswa | Formulir Digital</title>

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        :root {
            --primary: #6158e8;
            --primary-dark: #4840c7;
            --text: #252747;
            --muted: #8589a5;
            --danger: #dc3545;
            --border: #e7e8f2;
        }

        body {
            font-family: "Segoe UI", Arial, sans-serif;
            min-height: 100vh;
            padding: 38px 18px;
            color: var(--text);
            background: linear-gradient(
                135deg,
                #e8ecff,
                #f8f6ff,
                #e3f5ff
            );
            background-size: 200% 200%;
            animation: backgroundMove 12s ease infinite;
            overflow-x: hidden;
        }

        .orb {
            position: fixed;
            border-radius: 50%;
            filter: blur(2px);
            opacity: 0.38;
            pointer-events: none;
            z-index: -1;
            animation: float 8s ease-in-out infinite;
        }

        .orb-one {
            width: 220px;
            height: 220px;
            background: #a8b0ff;
            top: 4%;
            left: -80px;
        }

        .orb-two {
            width: 280px;
            height: 280px;
            background: #a8e8ff;
            right: -120px;
            bottom: 3%;
            animation-delay: -3s;
        }

        .container {
            max-width: 940px;
            margin: 0 auto;
            animation: appear 0.8s ease both;
        }

        .header {
            text-align: center;
            margin-bottom: 28px;
        }

        .brand {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 9px 16px;
            border: 1px solid rgba(97, 88, 232, 0.15);
            border-radius: 30px;
            background: rgba(255, 255, 255, 0.75);
            color: var(--primary);
            font-size: 12px;
            font-weight: 800;
            letter-spacing: 1.3px;
            margin-bottom: 17px;
        }

        .header h1 {
            font-size: clamp(27px, 5vw, 40px);
            line-height: 1.2;
            margin-bottom: 12px;
            letter-spacing: -1px;
        }

        .header h1 span {
            color: var(--primary);
        }

        .header p {
            color: #737894;
            font-size: 15px;
            line-height: 1.7;
        }

        .main-card {
            display: grid;
            grid-template-columns: 0.85fr 1.15fr;
            background: rgba(255, 255, 255, 0.94);
            border: 1px solid rgba(255, 255, 255, 0.9);
            border-radius: 26px;
            overflow: hidden;
            box-shadow: 0 24px 65px rgba(64, 65, 130, 0.13);
        }

        .side-panel {
            padding: 38px 30px;
            color: white;
            background: linear-gradient(155deg, #7068f1, #4840c7);
            position: relative;
            overflow: hidden;
        }

        .side-panel::after {
            content: "";
            position: absolute;
            width: 230px;
            height: 230px;
            border: 1px solid rgba(255,255,255,0.2);
            border-radius: 50%;
            right: -100px;
            bottom: -110px;
            box-shadow:
                0 0 0 25px rgba(255,255,255,0.04),
                0 0 0 50px rgba(255,255,255,0.04);
        }

        .side-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 76px;
            height: 76px;
            border-radius: 22px;
            background: rgba(255,255,255,0.15);
            border: 1px solid rgba(255,255,255,0.22);
            font-size: 37px;
            margin-bottom: 30px;
            animation: float 4s ease-in-out infinite;
        }

        .side-panel h2 {
            font-size: 25px;
            line-height: 1.35;
            margin-bottom: 14px;
        }

        .side-panel > p {
            color: #e5e4ff;
            font-size: 14px;
            line-height: 1.8;
        }

        .feature-list {
            list-style: none;
            margin-top: 28px;
            display: grid;
            gap: 15px;
        }

        .feature-list li {
            display: flex;
            gap: 10px;
            align-items: center;
            font-size: 13px;
            color: #f3f2ff;
        }

        .check {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            width: 23px;
            height: 23px;
            border-radius: 50%;
            background: rgba(255,255,255,0.17);
        }

        .form-panel {
            padding: 38px;
        }

        .form-heading {
            margin-bottom: 25px;
        }

        .form-heading h2 {
            font-size: 23px;
            margin-bottom: 7px;
        }

        .form-heading p {
            color: var(--muted);
            font-size: 13px;
            line-height: 1.6;
        }

        .alert {
            display: flex;
            align-items: flex-start;
            gap: 11px;
            padding: 14px 15px;
            margin-bottom: 20px;
            background: #fff0f1;
            color: #ad2634;
            border: 1px solid #ffd1d5;
            border-radius: 12px;
            font-size: 13px;
            line-height: 1.6;
        }

        .alert[hidden] {
            display: none;
        }

        .alert-icon {
            font-size: 19px;
        }

        .alert.show {
            animation: shake 0.35s ease, appear 0.25s ease;
        }

        .field {
            margin-bottom: 19px;
        }

        .field label {
            display: block;
            font-size: 13px;
            font-weight: 700;
            margin-bottom: 9px;
        }

        .label-required {
            color: var(--danger);
        }

        .input-wrap {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 17px;
            pointer-events: none;
        }

        .field input,
        .field select {
            width: 100%;
            height: 51px;
            padding: 0 14px 0 45px;
            background: #fafaff;
            color: var(--text);
            border: 1px solid var(--border);
            border-radius: 12px;
            font: inherit;
            font-size: 14px;
            outline: none;
            transition:
                border-color 0.25s,
                box-shadow 0.25s,
                background 0.25s,
                transform 0.25s;
        }

        .field input::placeholder {
            color: #adb0c4;
        }

        .field input:focus,
        .field select:focus {
            border-color: var(--primary);
            background: white;
            box-shadow: 0 0 0 4px rgba(97, 88, 232, 0.11);
            transform: translateY(-1px);
        }

        .field .is-invalid {
            border-color: var(--danger);
            background: #fffafb;
            box-shadow: 0 0 0 3px rgba(220, 53, 69, 0.08);
        }

        .field-error {
            display: block;
            color: var(--danger);
            font-size: 12px;
            margin-top: 7px;
            line-height: 1.5;
        }

        .field-error:empty {
            display: none;
        }

        .submit-btn {
            width: 100%;
            min-height: 52px;
            padding: 14px 18px;
            border: none;
            border-radius: 12px;
            margin-top: 3px;
            background: linear-gradient(120deg, #7169f1, #4e46ce);
            color: white;
            font-weight: 700;
            font-size: 14px;
            letter-spacing: 0.2px;
            cursor: pointer;
            box-shadow: 0 9px 22px rgba(97, 88, 232, 0.25);
            transition: transform 0.25s, box-shadow 0.25s;
        }

        .submit-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 13px 28px rgba(97, 88, 232, 0.33);
        }

        .submit-btn:active {
            transform: scale(0.98);
        }

        .privacy-note {
            color: #9699ae;
            text-align: center;
            font-size: 11px;
            line-height: 1.7;
            margin-top: 17px;
        }

        .result-card {
            margin-top: 25px;
            padding: 24px;
            border-radius: 18px;
            border: 1px solid #d5f2e2;
            background: linear-gradient(135deg, #f3fff8, #ffffff);
            animation: appear 0.55s ease both;
        }

        .result-title {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
        }

        .success-icon {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 39px;
            height: 39px;
            background: #d8f9e5;
            border-radius: 12px;
            font-size: 21px;
        }

        .result-title h3 {
            font-size: 17px;
            color: #197448;
        }

        .result-title p {
            margin-top: 3px;
            font-size: 12px;
            color: #63957a;
        }

        .result-row {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 16px;
            padding: 13px 0;
            border-bottom: 1px solid #e5f4ea;
            font-size: 13px;
        }

        .result-row:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }

        .result-row span {
            color: #779082;
        }

        .result-row strong {
            text-align: right;
            overflow-wrap: anywhere;
            color: #244b37;
        }

        footer {
            text-align: center;
            color: #8c90aa;
            font-size: 12px;
            margin-top: 25px;
            line-height: 1.7;
        }

        @keyframes appear {
            from {
                opacity: 0;
                transform: translateY(18px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-13px); }
        }

        @keyframes backgroundMove {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-4px); }
            75% { transform: translateX(4px); }
        }

        @media (max-width: 700px) {
            body {
                padding: 25px 14px;
            }

            .main-card {
                grid-template-columns: 1fr;
                border-radius: 21px;
            }

            .side-panel {
                padding: 27px 25px;
            }

            .side-icon {
                width: 60px;
                height: 60px;
                font-size: 29px;
                margin-bottom: 19px;
                border-radius: 17px;
            }

            .side-panel h2 {
                font-size: 22px;
            }

            .feature-list {
                grid-template-columns: 1fr;
                margin-top: 19px;
                gap: 10px;
            }

            .form-panel {
                padding: 27px 22px;
            }

            .header {
                margin-bottom: 21px;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            *,
            *::before,
            *::after {
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
            }
        }
    </style>
</head>

<body>

    <div class="orb orb-one"></div>
    <div class="orb orb-two"></div>

    <main class="container">

        <header class="header">
            <div class="brand">
                <span>✦</span> FORMULIR DIGITAL SISWA
            </div>

            <h1>Identitas <span>Siswa</span></h1>

            <p>
                Lengkapi data dirimu dengan benar untuk melanjutkan.
                <br>Pastikan semua kolom sudah terisi.
            </p>
        </header>

        <section class="main-card">

            <aside class="side-panel">
                <div class="side-icon">🎓</div>

                <h2>Kenali Dirimu,<br>Mulai dari Sini.</h2>

                <p>
                    Isi formulir identitas siswa dengan lengkap.
                    Data yang kamu masukkan akan ditampilkan kembali
                    setelah formulir berhasil dikirim.
                </p>

                <ul class="feature-list">
                    <li>
                        <span class="check">✓</span>
                        Formulir sederhana dan mudah digunakan
                    </li>
                    <li>
                        <span class="check">✓</span>
                        Peringatan input kosong secara otomatis
                    </li>
                    <li>
                        <span class="check">✓</span>
                        Validasi data dengan PHP
                    </li>
                </ul>
            </aside>

            <div class="form-panel">

                <div class="form-heading">
                    <h2>Data Siswa</h2>
                    <p>Kolom bertanda <span class="label-required">*</span>
                    wajib diisi.</p>
                </div>

                <div
                    id="clientAlert"
                    class="alert"
                    role="alert"
                    aria-live="assertive"
                    hidden
                >
                    <span class="alert-icon">⚠️</span>
                    <div id="alertMessage"></div>
                </div>

                <?php if ($isSubmitted && !empty($errors)): ?>
                    <div class="alert" role="alert" aria-live="assertive">
                        <span class="alert-icon">⚠️</span>
                        <div>
                            <strong>Data belum lengkap!</strong><br>
                            Silakan periksa dan lengkapi kolom yang ditandai.
                        </div>
                    </div>
                <?php endif; ?>

                <form id="identityForm" method="post" novalidate>

                    <div class="field">
                        <label for="nama">
                            Nama Lengkap <span class="label-required">*</span>
                        </label>

                        <div class="input-wrap">
                            <span class="input-icon">👤</span>
                            <input
                                type="text"
                                id="nama"
                                name="nama"
                                data-required
                                data-label="Nama lengkap"
                                class="<?= isset($errors['nama']) ? 'is-invalid' : '' ?>"
                                placeholder="Masukkan nama lengkap"
                                value="<?= e($nama) ?>"
                                autocomplete="name"
                                aria-invalid="<?= isset($errors['nama']) ? 'true' : 'false' ?>"
                                aria-describedby="nama-error"
                            >
                        </div>

                        <small class="field-error" id="nama-error"><?= e($errors['nama'] ?? '') ?></small>
                    </div>

                    <div class="field">
                        <label for="kelas">
                            Kelas <span class="label-required">*</span>
                        </label>

                        <div class="input-wrap">
                            <span class="input-icon">🏫</span>
                            <input
                                type="text"
                                id="kelas"
                                name="kelas"
                                data-required
                                data-label="Kelas"
                                class="<?= isset($errors['kelas']) ? 'is-invalid' : '' ?>"
                                placeholder="Contoh: XI RPL 1"
                                value="<?= e($kelas) ?>"
                                aria-invalid="<?= isset($errors['kelas']) ? 'true' : 'false' ?>"
                                aria-describedby="kelas-error"
                            >
                        </div>

                        <small class="field-error" id="kelas-error"><?= e($errors['kelas'] ?? '') ?></small>
                    </div>

                    <div class="field">
                        <label for="jurusan">
                            Jurusan <span class="label-required">*</span>
                        </label>

                        <div class="input-wrap">
                            <span class="input-icon">💻</span>
                            <input
                                type="text"
                                id="jurusan"
                                name="jurusan"
                                data-required
                                data-label="Jurusan"
                                class="<?= isset($errors['jurusan']) ? 'is-invalid' : '' ?>"
                                placeholder="Contoh: Rekayasa Perangkat Lunak"
                                value="<?= e($jurusan) ?>"
                                aria-invalid="<?= isset($errors['jurusan']) ? 'true' : 'false' ?>"
                                aria-describedby="jurusan-error"
                            >
                        </div>

                        <small class="field-error" id="jurusan-error"><?= e($errors['jurusan'] ?? '') ?></small>
                    </div>

                    <button type="submit" class="submit-btn">
                        Kirim Data Siswa &nbsp; →
                    </button>

                    <p class="privacy-note">
                        ✨ Periksa kembali identitasmu sebelum mengirim.
                    </p>

                </form>

                <?php if ($isSubmitted && empty($errors)): ?>
                    <section class="result-card" aria-live="polite">
                        <div class="result-title">
                            <div class="success-icon">✓</div>
                            <div>
                                <h3>Data Berhasil Dikirim!</h3>
                                <p>Formulir identitas berhasil diproses.</p>
                            </div>
                        </div>

                        <div class="result-row">
                            <span>Nama lengkap</span>
                            <strong><?= e($nama) ?></strong>
                        </div>

                        <div class="result-row">
                            <span>Kelas</span>
                            <strong><?= e($kelas) ?></strong>
                        </div>

                        <div class="result-row">
                            <span>Jurusan</span>
                            <strong><?= e($jurusan) ?></strong>
                        </div>
                    </section>
                <?php endif; ?>

            </div>
        </section>

        <footer>
            Praktik Pemrograman Web · Event Handling PHP<br>
            Dibuat untuk latihan formulir identitas siswa.
        </footer>

    </main>

    <script>
        const form = document.getElementById('identityForm');
        const alertBox = document.getElementById('clientAlert');
        const alertMessage = document.getElementById('alertMessage');
        const fields = Array.from(
            form.querySelectorAll('[data-required]')
        );

        let validationAttempted = false;

        function validateField(field) {
            const errorElement = document.getElementById(
                field.name + '-error'
            );

            const isEmpty = field.value.trim() === '';

            field.classList.toggle('is-invalid', isEmpty);
            field.setAttribute('aria-invalid', String(isEmpty));

            if (isEmpty) {
                errorElement.textContent =
                    field.dataset.label + ' wajib diisi.';
            } else {
                errorElement.textContent = '';
            }

            return !isEmpty;
        }

        form.addEventListener('submit', function (event) {
            validationAttempted = true;

            const invalidFields = fields.filter(function (field) {
                return !validateField(field);
            });

            if (invalidFields.length > 0) {
                event.preventDefault();

                const missingNames = invalidFields.map(function (field) {
                    return field.dataset.label;
                });

                alertMessage.textContent =
                    'Mohon lengkapi kolom berikut: ' +
                    missingNames.join(', ') + '.';

                alertBox.hidden = false;
                alertBox.classList.remove('show');

                // Memicu animasi peringatan.
                void alertBox.offsetWidth;
                alertBox.classList.add('show');

                invalidFields[0].focus();

                alertBox.scrollIntoView({
                    behavior: 'smooth',
                    block: 'nearest'
                });
            } else {
                alertBox.hidden = true;
            }
        });

        fields.forEach(function (field) {
            field.addEventListener('input', function () {
                if (validationAttempted) {
                    validateField(field);

                    const allFilled = fields.every(function (item) {
                        return item.value.trim() !== '';
                    });

                    if (allFilled) {
                        alertBox.hidden = true;
                    }
                }
            });
        });
    </script>

</body>
</html>
