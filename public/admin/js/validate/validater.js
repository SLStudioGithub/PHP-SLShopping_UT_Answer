/**
 * 整数か判定
 * 
 * @param {number|string} inputValue 
 * @returns {boolean}
 */
export const isNumber = (inputValue) => {
    return Number.isInteger(parseInt(inputValue))
}

/**
 * @var {number} maxNumber 許容数値
 */
export const maxNumber = 999999999

/**
 * 許容数値以下か判定
 * 
 * @param {number} inputValue 
 * @returns {boolean}
 */
export const isLessThanMaxNumber = (inputValue) => {
    return inputValue <= maxNumber
}