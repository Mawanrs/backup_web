<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Table Form</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
    integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/assets/css/stylee.css">
</head>
<body>
    <hr>
    <br>
    <h3>Booking Table Form</h3>
    <form name="myForm" action="{{ route('booking.post') }}" id="formData" method="post">
        @csrf
        <div class="mb-3">
            <label for="namaPemesan" class="form-label">Nama Pemesan:</label>
            <input type="text" name="nama_pemesan" id="namaPemesan" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="category" class="form-label">Category:</label>
            <select name="category" id="category" class="form-select" required>
                <option value="open">Open</option>
                <option value="packet">Packet</option>
                <option value="promo">Promo</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="startDateTime" class="form-label">Start Book:</label>
            <input type="datetime-local" name="startDateTime" id="startDateTime" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="finishDateTime" class="form-label">Finish Book:</label>
            <input type="datetime-local" name="finishDateTime" id="finishDateTime" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="status" class="form-label">Status:</label>
            <select name="status" id="status" class="form-select" required>
                <option value="booking">Booking</option>
                <option value="available">Available</option>
                <option value="cancelled">Cancelled</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Book Room</button>
    </form>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('formData');

            form.addEventListener('submit', function(e) {
                e.preventDefault();

                // Kirim form data menggunakan AJAX
                const formData = new FormData(form);
                fetch(form.getAttribute('action'), {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Tampilkan sweet alert jika data berhasil disimpan
                        Swal.fire({
                            title: 'Success!',
                            text: data.message,
                            icon: 'success',
                            confirmButtonText: 'OK'
                        });
                        form.reset();
                    } else {
                        // Tampilkan sweet alert jika terjadi error
                        Swal.fire({
                            title: 'Error!',
                            text: data.message,
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        title: 'Error!',
                        text: 'Something went wrong!',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                });
            });
        });
    </script>
</body>
</html>
