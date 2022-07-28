$(function () {
    // 削除モーダル関連処理
    // 削除ボタンクリック時にモーダル表示
    $('#delete-button').click(function () {
        $('#deleteModal').modal('show')
    })

    // キャンセルボタンクリック時にモーダル閉じる
    $('#cancel-button').click(function () {
        $('#deleteModal').modal('hide')
    })

    // エラーモーダル関連処理
    // エラーモーダルはある場合は初期表示時に表示
    if ($('#errorModal').length) {
        $('#errorModal').modal('show')
    }

    // 閉じるボタンクリック時にモーダルを閉じる
    $('#close-button').click(function () {
        $('#errorModal').modal('hide')
    })

    // 成功モーダル関連処理
    // 成功モーダルがある場合は初期表示時に表示
    if ($('#successModal').length) {
        $('#successModal').modal('show')
    }

    // 閉じるボタンクリック時にモーダルを閉じる
    $('#success-close-button').click(function () {
        $('#successModal').modal('hide')
    })
})