$(document).ready(function() {
    $('#submitBtn').on('click', function() {
        // 1. 抓取表單資料
        let userName = $('#userName').val();

        // 2. 如果有檔案上傳，要用 FormData
        let formData = new FormData();
        formData.append('user', userName);
        // 如果有檔案：formData.append('photo', $('#photo')[0].files[0]);

        // 3. 發送 AJAX
        $.ajax({
            url: 'http://localhost/PRACTICEPAGE/web13/api.php', // 確保從 html 出發能找到 php 檔案
            type: 'POST',
            data: formData,
            contentType: false, // 檔案上傳必設
            processData: false, // 檔案上傳必設
            success: function(res) {
                // res 就是 PHP 傳回來的 JSON 物件
                if (res.success) {
                    alert(res.message);
                    // 可以在這裡動態更新 DOM，不用重新整理網頁
                    $('#resultList').append('<li>' + userName + ' 已成功加入</li>');
                } else {
                    alert('失敗：' + res.message);
                }
            },
            error: function() {
                alert('連線伺服器失敗');
            }
        });
    });
});