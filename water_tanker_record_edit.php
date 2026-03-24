<?php
session_start();

if (!isset($_SESSION['loggedin'])) {
    header('Location: login.php');
    exit;
}

include 'dbconfig.php';
date_default_timezone_set("Asia/Karachi");

function h($s)
{
    return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8');
}

$form_user = $_SESSION['fullname'] ?? ($_SESSION['username'] ?? ($_SESSION['email'] ?? 'unknown'));

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) {
    header("Location: water_tanker_record_list.php?status=notfound");
    exit;
}

/* ----------------- Fetch existing record ----------------- */
$stmt = $conn->prepare("SELECT id, `date`, slip_no, deliver_at, amount, reason_for, form_user FROM water_tanker_form WHERE id = ? LIMIT 1");
$stmt->bind_param("i", $id);
$stmt->execute();
$res = $stmt->get_result();
$record = $res->fetch_assoc();
$stmt->close();

if (!$record) {
    header("Location: water_tanker_record_list.php?status=notfound");
    exit;
}

$status = $_GET['status'] ?? '';

/* ----------------- Handle POST (Update) ----------------- */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {

    $date = trim($_POST['date'] ?? ''); // hidden yyyy-mm-dd
    $slip_no = trim($_POST['slip_no'] ?? '');
    $deliver_at = trim($_POST['deliver_at'] ?? '');
    $amount = trim($_POST['amount'] ?? '');
    $reason_for = trim($_POST['reason_for'] ?? '');

    $ok = true;

    $d = DateTime::createFromFormat('Y-m-d', $date);
    if (!$d || $d->format('Y-m-d') !== $date) $ok = false;

    if ($slip_no === '' || strlen($slip_no) > 50) $ok = false;
    if ($deliver_at === '' || strlen($deliver_at) > 150) $ok = false;

    if ($amount === '' || !is_numeric($amount) || (float)$amount < 0) $ok = false;

    if ($reason_for === '' || strlen($reason_for) > 500) $ok = false;

    if ($ok) {
        $stmtU = $conn->prepare("
            UPDATE water_tanker_form
            SET `date` = ?, slip_no = ?, deliver_at = ?, amount = ?, reason_for = ?, updated_at = CURRENT_TIMESTAMP
            WHERE id = ?
            LIMIT 1
        ");

        if ($stmtU) {
            $amt = number_format((float)$amount, 2, '.', '');
            $stmtU->bind_param("sssdsi", $date, $slip_no, $deliver_at, $amt, $reason_for, $id);
            $exec = $stmtU->execute();
            $affected = $stmtU->affected_rows;
            $stmtU->close();

            if ($exec) {
                // If user saved without changes, still show a friendly toast
                if ($affected > 0) {
                    header("Location: water_tanker_record_edit.php?id=" . $id . "&status=updated");
                } else {
                    header("Location: water_tanker_record_edit.php?id=" . $id . "&status=nochange");
                }
                exit;
            } else {
                header("Location: water_tanker_record_edit.php?id=" . $id . "&status=failed");
                exit;
            }
        } else {
            header("Location: water_tanker_record_edit.php?id=" . $id . "&status=failed");
            exit;
        }
    } else {
        header("Location: water_tanker_record_edit.php?id=" . $id . "&status=invalid");
        exit;
    }
}

/* ----------------- Re-fetch record (so UI always shows latest) ----------------- */
$stmt = $conn->prepare("SELECT id, `date`, slip_no, deliver_at, amount, reason_for, form_user FROM water_tanker_form WHERE id = ? LIMIT 1");
$stmt->bind_param("i", $id);
$stmt->execute();
$res = $stmt->get_result();
$record = $res->fetch_assoc();
$stmt->close();

/* ----------------- Values for form (prefill) ----------------- */
$val_date_db = (string)$record['date']; // Y-m-d
$dt2 = DateTime::createFromFormat('Y-m-d', $val_date_db);
$val_date_ui = $dt2 ? $dt2->format('d-m-Y') : $val_date_db;

$val_slip = (string)$record['slip_no'];
$val_deliver = (string)$record['deliver_at'];
$val_amount = number_format((float)$record['amount'], 2, '.', '');
$val_reason = (string)$record['reason_for'];

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>MedicsFlow</title>
    <link rel="shortcut icon" type="image/jpg" href="assets/images/fevicon.png" />

    <?php include 'cdncss.php'; ?>

    <style>
        .bg-menu {
            background-color: #393E46 !important;
        }

        .btn-menu {
            font-size: 12.5px;
            background-color: #FFB22C !important;
            padding: 5px 10px;
            font-weight: 600;
            border: none !important;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f5f6fa;
        }

        .card {
            border-radius: 10px;
        }

        label {
            font-weight: 500;
            font-size: 12px;
        }

        input {
            width: 100% !important;
            font-size: 13px;
            border-radius: 0px;
            border: 1px solid grey;
            transition: border-color 0.3s ease;
            padding: 2.5px 5px;
            letter-spacing: 0.4px;
            height: 25px !important;
            color: black !important;
        }

        input:focus {
            outline: none;
            border: 1px solid black;
            background-color: #FFF4B5;
        }

        textarea {
            border: 0.5px solid #adb5bd !important;
            border-radius: 0px !important;
        }

        .is-invalid {
            border: 1.5px solid red !important;
            background-color: #fff0f0;
        }

        .labelf {
            font-size: 13.5px !important;
            font-weight: 500;
        }

        .bg-header {
            background-color: #1f7a8c;
        }

        .btn-form,
        .btn-form:hover {
            background-color: #0e6ba8;
            border-radius: 20px;
            color: white;
        }

        /* Toast styles same as water_tanker_form */
        .toast-custom {
            background: #ffffff !important;
            color: #111 !important;
            border: 1px solid #dee2e6 !important;
            border-left-width: 6px !important;
            border-radius: 10px !important;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.12);
        }

        .toast-success {
            border-color: #28a745 !important;
            border-left-color: #28a745 !important;
        }

        .toast-error {
            border-color: #dc3545 !important;
            border-left-color: #dc3545 !important;
        }

        .toast-warning {
            border-color: #ffc107 !important;
            border-left-color: #ffc107 !important;
        }

        .toast-custom .btn-close {
            filter: none !important;
            opacity: 0.6;
        }

        .toast-custom .btn-close:hover {
            opacity: 1;
        }

        .btn-cancel,
        .btn-cancel:hover {
            border-radius: 20px;
            padding-left: 1.5rem;
            padding-right: 1.5rem;
        }
    </style>

    <?php include 'sidebarcss.php'; ?>
</head>

<body>
    <div class="wrapper">
        <?php include 'sidebar1.php'; ?>

        <div id="content">
            <nav class="navbar navbar-expand-lg bg-menu">
                <div class="container-fluid">
                    <button type="button" id="sidebarCollapse" class="btn-menu">
                        <i class="fas fa-align-left"></i> <span>Menu</span>
                    </button>
                </div>
            </nav>

            <div class="container-fluid">
                <div class="row justify-content-center mt-5">
                    <div class="col-md-8 pt-md-2">

                        <form class="form pb-3" method="POST" autocomplete="off">
                            <div class="card shadow">
                                <div class="card-header bg-header text-white d-flex justify-content-between align-items-center">
                                    <h6 class="mb-0">Edit Water Tanker Record</h6>
                                    <a href="water_tanker_record_list.php" class="btn btn-light btn-sm">
                                        <i class="fa-solid fa-home"></i> Home
                                    </a>
                                </div>

                                <div class="card-body">
                                    <div class="row g-3">
                                        <div class="col-md-4">
                                            <label class="form-label labelf">Date</label>
                                            <input type="text" id="date_ui" value="<?php echo h($val_date_ui); ?>" readonly>
                                            <input type="hidden" id="date" name="date" value="<?php echo h($val_date_db); ?>">
                                        </div>

                                        <div class="col-md-4">
                                            <label class="form-label labelf">Slip No</label>
                                            <input type="text" name="slip_no" id="slip_no" maxlength="50"
                                                value="<?php echo h($val_slip); ?>" placeholder="Enter slip no">
                                            <small id="slipNoError" class="text-danger d-none"></small>
                                        </div>

                                        <div class="col-md-4">
                                            <label class="form-label labelf">Deliver At</label>
                                            <input type="text" name="deliver_at" id="deliver_at" maxlength="150"
                                                value="<?php echo h($val_deliver); ?>" placeholder="Deliver location">
                                            <small id="deliverAtError" class="text-danger d-none"></small>
                                        </div>

                                        <div class="col-md-4">
                                            <label class="form-label labelf">Amount</label>
                                            <input type="text" name="amount" id="amount"
                                                value="<?php echo h($val_amount); ?>" placeholder="0.00">
                                            <small id="amountError" class="text-danger d-none"></small>
                                        </div>

                                        <div class="col-md-8">
                                            <label class="form-label labelf">Reason For</label>
                                            <textarea class="form-control" name="reason_for" id="reason_for"
                                                rows="2" minlength="3" maxlength="500"
                                                placeholder="Reason..."><?php echo h($val_reason); ?></textarea>
                                            <small id="reasonError" class="text-danger d-none"></small>
                                        </div>
                                    </div>

                                    <div class="text-center mt-4">
                                        <button type="submit" name="update" class="btn btn-form px-4">
                                            Update
                                        </button>

                                        <a href="water_tanker_record_list.php" class="btn btn-secondary btn-cancel">
                                            Cancel
                                        </a>
                                    </div>

                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>

            <!-- Toast Container -->
            <div class="position-fixed top-0 end-0 p-3" style="z-index: 9999;">
                <div id="statusToast" class="toast toast-custom align-items-center" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="d-flex">
                        <div class="toast-body" id="toastMsg">...</div>
                        <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                </div>
            </div>

            <?php include 'footer.php'; ?>
        </div>
    </div>

    <!-- Bootstrap JS required for Toast -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const status = "<?php echo h($status); ?>";
            const toastEl = document.getElementById("statusToast");
            const toastMsg = document.getElementById("toastMsg");

            function setToastType(type) {
                toastEl.classList.remove("toast-success", "toast-error", "toast-warning");
                if (type) toastEl.classList.add(type);
            }

            if (status) {
                if (status === "updated") {
                    toastMsg.textContent = "Record updated successfully!";
                    setToastType("toast-success");
                } else if (status === "nochange") {
                    toastMsg.textContent = "No changes were made.";
                    setToastType("toast-warning");
                } else if (status === "failed") {
                    toastMsg.textContent = "Update failed!";
                    setToastType("toast-error");
                } else if (status === "invalid") {
                    toastMsg.textContent = "Please fill all fields correctly.";
                    setToastType("toast-warning");
                } else {
                    toastMsg.textContent = "Something happened.";
                    setToastType("toast-warning");
                }

                const toast = new bootstrap.Toast(toastEl, {
                    delay: 2500
                });
                toast.show();

                // Clean URL (remove ?status=...) without reload
                const url = new URL(window.location.href);
                url.searchParams.delete("status");
                window.history.replaceState({}, document.title, url.toString());
            }

            // ===== Client-side validation =====
            const form = document.querySelector("form");
            const slipNo = document.getElementById("slip_no");
            const deliverAt = document.getElementById("deliver_at");
            const amount = document.getElementById("amount");
            const reason = document.getElementById("reason_for");

            const slipNoError = document.getElementById("slipNoError");
            const deliverAtError = document.getElementById("deliverAtError");
            const amountError = document.getElementById("amountError");
            const reasonError = document.getElementById("reasonError");

            function setError(input, errorElem, msg) {
                input.classList.add("is-invalid");
                errorElem.textContent = msg;
                errorElem.classList.remove("d-none");
            }

            function clearError(input, errorElem) {
                input.classList.remove("is-invalid");
                errorElem.textContent = "";
                errorElem.classList.add("d-none");
            }

            function validateSlipNo() {
                const v = slipNo.value.trim();
                if (!v) {
                    setError(slipNo, slipNoError, "Slip No is required.");
                    return false;
                }
                if (v.length > 50) {
                    setError(slipNo, slipNoError, "Max 50 characters.");
                    return false;
                }
                clearError(slipNo, slipNoError);
                return true;
            }

            function validateDeliverAt() {
                const v = deliverAt.value.trim();
                if (!v) {
                    setError(deliverAt, deliverAtError, "Deliver At is required.");
                    return false;
                }
                if (v.length > 150) {
                    setError(deliverAt, deliverAtError, "Max 150 characters.");
                    return false;
                }
                clearError(deliverAt, deliverAtError);
                return true;
            }

            function validateAmount() {
                const v = amount.value.trim();
                if (!v) {
                    setError(amount, amountError, "Amount is required.");
                    return false;
                }
                const num = Number(v);
                if (Number.isNaN(num) || num < 0) {
                    setError(amount, amountError, "Enter a valid non-negative number.");
                    return false;
                }
                clearError(amount, amountError);
                return true;
            }

            function validateReason() {
                const v = reason.value.trim();
                if (!v) {
                    setError(reason, reasonError, "Reason is required.");
                    return false;
                }
                if (v.length > 500) {
                    setError(reason, reasonError, "Max 500 characters.");
                    return false;
                }
                clearError(reason, reasonError);
                return true;
            }

            slipNo.addEventListener("input", validateSlipNo);
            deliverAt.addEventListener("input", validateDeliverAt);
            amount.addEventListener("input", validateAmount);
            reason.addEventListener("input", validateReason);

            form.addEventListener("submit", function(e) {
                const ok = [validateSlipNo(), validateDeliverAt(), validateAmount(), validateReason()].every(Boolean);
                if (!ok) {
                    e.preventDefault();
                    if (slipNo.classList.contains("is-invalid")) slipNo.focus();
                    else if (deliverAt.classList.contains("is-invalid")) deliverAt.focus();
                    else if (amount.classList.contains("is-invalid")) amount.focus();
                    else reason.focus();
                }
            });
        });
    </script>
</body>

</html>