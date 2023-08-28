        function updateClock() {
            // Buat objek XMLHttpRequest untuk mengambil waktu dari server NTP
            var xhr = new XMLHttpRequest();
            xhr.open("GET", "https://worldtimeapi.org/api/timezone/Asia/Jakarta", true);
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    // Parse JSON respons untuk mendapatkan waktu
                    var response = JSON.parse(xhr.responseText);
                    var dateTime = new Date(response.utc_datetime);

                    // Daftar nama hari dalam bahasa Indonesia
                    var days = ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"];

                    // Daftar nama bulan dalam bahasa Indonesia
                    var months = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];

                    // Ambil informasi hari, tanggal, bulan, tahun, jam, menit, dan detik
                    var dayOfWeek = days[dateTime.getDay()];
                    var dayOfMonth = dateTime.getDate();
                    var month = months[dateTime.getMonth()];
                    var year = dateTime.getFullYear();
                    var hours = dateTime.getHours();
                    var minutes = dateTime.getMinutes();
                    var seconds = dateTime.getSeconds();

                    // Format waktu dengan nol di depan jika kurang dari 10
                    dayOfMonth = (dayOfMonth < 10) ? '0' + dayOfMonth : dayOfMonth;
                    hours = (hours < 10) ? '0' + hours : hours;
                    minutes = (minutes < 10) ? '0' + minutes : minutes;
                    seconds = (seconds < 10) ? '0' + seconds : seconds;

                    // Tampilkan waktu dalam format yang diinginkan
                    var timeString = dayOfWeek + ', ' + dayOfMonth + ' ' + month + ' ' + year + ' ' + hours + ':' + minutes + ':' + seconds;

                    // Perbarui elemen HTML dengan waktu yang baru
                    document.getElementById('clock').textContent = timeString;
                }
            };
            xhr.send();
        }

        // Panggil fungsi updateClock setiap detik
        setInterval(updateClock, 1000);

        // Panggil updateClock untuk pertama kali
        updateClock();
