import { isNumber, isLessThanMaxNumber } from '../validate/validater.js'
import { messages } from '../validate/message.js'

$(function () {
    // 検索フォーム送信時
    $('#search-form').submit(function () {
        // 初期設定
        // エラーメッセージ要素map
        let errorMaps = {
            id: {
                element: $('#id-error')
            },
        }
        // 全てのエラーメッセージを非表示
        Object.keys(errorMaps).forEach(key => {
            errorMaps[key].isError = false
            errorMaps[key].element.css('display', 'none')
        })

        // バリデーション処理
        // IDバリデーション
        const id = $('#id').val()
        if (id) {
            if (!isNumber(id) || !isLessThanMaxNumber(id)) {
                errorMaps.id.isError = true
                errorMaps.id.element.text(messages.isNotNumber)
            }
        }

        // バリデーションエラーの有無判定
        // エラーになった要素のキーを取得
        const errors = Object.keys(errorMaps).filter(key => errorMaps[key].isError)
        // エラーがない場合が送信
        if (errors.length === 0) return true
        // エラーメッセージを表示
        errors.forEach(key => errorMaps[key].element.css('display', 'block'))
        return false
    })
})