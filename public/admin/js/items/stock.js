import { isNumber, isLessThanMaxNumber} from '../validate/validater.js'
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
            lowStock: {
                element: $('#low-stock-error')
            },
            highStock: {
                element: $('#high-stock-error')
            },
            brandId: {
                element: $('#brand-id-error')
            },
            categoryId: {
                element: $('#category-id-error')
            }
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
        // 下限在庫数バリデーション
        const lowStock = $('#low-stock').val()
        if (lowStock) {
            if (!isNumber(lowStock) || !isLessThanMaxNumber(lowStock)) {
                errorMaps.lowStock.isError = true
                errorMaps.lowStock.element.text(messages.isNotNumber)
            }
        }
        // 上限在庫数バリデーション
        const highStock = $('#high-stock').val()
        if (highStock) {
            if (!isNumber(highStock) || !isLessThanMaxNumber(highStock)) {
                errorMaps.highStock.isError = true
                errorMaps.highStock.element.text(messages.isNotNumber)
            }
        }
        // ブランドバリデーション
        const brandId = $('#brand-id').val()
        if (brandId) {
            if (!isNumber(brandId) || !isLessThanMaxNumber(brandId)) {
                errorMaps.brandId.isError = true
                errorMaps.brandId.element.text(messages.isNotNumber)
            }
        }
        // カテゴリーバリデーション
        const categoryId = $('#category-id').val()
        if (categoryId) {
            if (!isNumber(categoryId) || !isLessThanMaxNumber(categoryId)) {
                errorMaps.categoryId.isError = true
                errorMaps.categoryId.element.text(messages.isNotNumber)
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