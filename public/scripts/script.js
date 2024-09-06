window.addEventListener('load', () => {
    const navbar = document.querySelector('#navbar')

    if (navbar) {
        navbar.addEventListener('click', (e) => {
            if (e.target.classList.contains('btn-menu')) {
                e.target.parentNode.classList.toggle('open')
            }
        })
    }

    const crudProduct = document.querySelector('#crud-product')

    if (crudProduct) {
        imgContent = crudProduct.querySelector('.image-content')
        img = imgContent.querySelector('img')
        titleImg = imgContent.querySelector('.title-img')
        textImg = imgContent.querySelector('.text-img')

        imagesContent = crudProduct.querySelector('.images-content')
        cantidad = crudProduct.querySelector('.images-info .cantidad')

        const allImg = crudProduct.querySelectorAll('IMG')

        allImg.forEach(img => {
            resize(img)
        })

        var dataFiles = []

        crudProduct.addEventListener('input', (e) => {
            if (e.target.type == 'file') {
                files = e.target.files

                if (files.length > 0) {
                    imagesCount = imagesContent.children.length

                    added = (files.length <= 5) ? files.length : 5

                    if ((added + imagesCount) > 5) {
                        added = 5 - imagesCount
                    }

                    for (i = 0; i < files.length; i++) {
                        if (imagesCount <= 4) {
                            file = files[i]

                            if (file.type && file.type.startsWith('image/')) {
                                imagesCount++
                                dataFiles[imagesCount - 1] = file

                                divImage = document.createElement('div')
                                divImage.classList = 'image'

                                image = document.createElement('img')
                                image.onload = function () { this.src }
                                image.src = URL.createObjectURL(file)

                                divImage.appendChild(image)
                                divImage.innerHTML += '<div class="remove"><i class="fa-solid fa-x"></i></div>'

                                imagesContent.appendChild(divImage)
                            }
                        } else {
                            break
                        }
                    }

                    lastFile = files[(files.length - 1)]

                    if (lastFile.type && lastFile.type.startsWith('image/')) {
                        if (img.classList.contains('no-src')) { img.classList.remove('no-src') }
                        img.src = imagesContent.children[imagesCount - 1].querySelector('IMG').src
                        
                        titleImg.textContent = 'Imágen agregadas (' + added + ')'
                        
                        if (files.length > 1) {
                            textImg.textContent = files[added - 1].name + ' ...'
                        } else {
                            textImg.textContent = files[added - 1].name
                        }

                        img.closest('.input-file').querySelector('input').value = ''
                    }

                    cantidad.textContent = imagesCount + ' imágenes de 5'

                    const allImg = crudProduct.querySelectorAll('IMG')
                    allImg.forEach(img => resizeOnLoad(img))
                }
            }
        })

        crudProduct.addEventListener('click', (e) => {
            inputSaveImg = crudProduct.querySelector('[name="save_img"]')
            
            if (e.target.classList.contains('image')) {
                index = Array.prototype.indexOf.call(imagesContent.children, e.target)
                
                dataFiles.splice(index, 1)
                e.target.remove()
                
                imagesCount = imagesContent.children.length

                if (imagesCount > 0) {
                    img.src = imagesContent.children[imagesCount - 1].querySelector('IMG').src
                    resize(img)

                    if (inputSaveImg) {
                        saveImg = JSON.parse(inputSaveImg.value)
                        saveImg.splice(index, 1)
                        inputSaveImg.value = JSON.stringify(saveImg)
                    }
                } else {
                    img.src = ''
                    titleImg.textContent = 'Sin imágenes'
                    textImg.textContent = '...'
                    img.closest('.input-file').querySelector('input').value = ''
                    if (!img.classList.contains('no-src')) { img.classList.add('no-src') }
                    
                    if (inputSaveImg) {
                        inputSaveImg.value = null
                    }
                }

                imagesCount = imagesContent.children.length
                cantidad.textContent = imagesCount + ' imágenes de 5'
            }

            if (e.target.tagName == 'BUTTON' && e.target.name) {
                e.preventDefault()

                var formData = new FormData(crudProduct)
                formData.append(e.target.name, true)
                
                if (inputSaveImg && inputSaveImg.value != '') {
                    inputSaveImg = JSON.parse(inputSaveImg.value)
                    
                    for (var i = 0; i < inputSaveImg.length; i++) {
                        formData.append('save_img[]', inputSaveImg[i]);
                    }
                }

                for (var i = 0; i < dataFiles.length; i++) {
                    formData.append('img_prd[]', dataFiles[i]);
                }

                $.ajax({
                    url: '?ajax=producto&&func=crud',
                    data: formData,
                    type: 'POST',
                    processData: false,
                    contentType: false,

                    success: function (html) {
                        $('.alert').html(html)
                    }
                })
            }
        })
    }

    const productList = document.querySelector('#product-list')

    if (productList && productList.children.length > 1) {
        const allImg = productList.querySelectorAll('IMG')
        const titleSearch = productList.querySelectorAll('.title-search')
        const originPos = []
        const originNum = []

        allImg.forEach(img => {
            resize(img)
        })

        Array.from(productList.children).forEach((product, index) => {
            if (index === 0) {
                product.classList.add('first')
            }

            originPos.push(product)
            originNum.push(index)
        })

        document.getElementById('input-search').addEventListener('input', (e) => {
            const inputValue = e.target.value.trim().toLowerCase()
            first = false
            const products = []
            const numbers = []

            titleSearch.forEach(title => {
                const product = title.closest('.product')
                let pass = false

                if (product.classList.contains('first')) product.classList.remove('first')
                if (productList.classList.contains('empty')) productList.classList.remove('empty')

                const word = similarity(title.textContent.toLowerCase(), inputValue)

                if (word >= 30 || title.textContent.toLowerCase().includes(inputValue)) {
                    pass = true
                    product.removeAttribute('style')

                    if (!first) {
                        first = true
                        product.classList.add('first')
                    }
                } else {
                    product.style.display = 'none'
                }

                products.push(product)
                numbers.push([word, pass])
            })

            if (inputValue !== '') {
                products.sort((a, b) => numbers[0][products.indexOf(b)] - numbers[0][products.indexOf(a)])
            } else {
                originPos.sort((a, b) => originNum[originPos.indexOf(b)] - originNum[originPos.indexOf(a)])
            }

            products.forEach(product => {
                productList.appendChild(product)
            })

            if (!numbers.some(subArray => subArray.includes(true))) {
                productList.classList.add('empty')
            }
        })

        productList.addEventListener('click', (e) => {
            if (e.target.classList.contains('image')) {
                const images = e.target.closest('.images')
                const img = images.querySelector('.content-img img')

                img.src = e.target.children[0].src
                img.parentNode.href = img.src
                resize(img)
            }
        })

        function levenshtein(a, b) {
            const m = a.length, n = b.length
            const dp = Array.from(Array(m + 1), () => Array(n + 1).fill(0))

            for (let i = 0; i <= m; i++) {
                dp[i][0] = i
            }

            for (let j = 0; j <= n; j++) {
                dp[0][j] = j
            }

            for (let i = 1; i <= m; i++) {
                for (let j = 1; j <= n; j++) {
                    const cost = a[i - 1] === b[j - 1] ? 0 : 1;
                    dp[i][j] = Math.min(
                        dp[i - 1][j] + 1,
                        dp[i][j - 1] + 1,
                        dp[i - 1][j - 1] + cost
                    )
                }
            }

            return dp[m][n]
        }

        function similarity(a, b) {
            const maxLen = Math.max(a.length, b.length)
            const distance = levenshtein(a, b)
            const percentSimilarity = ((maxLen - distance) / maxLen) * 100
            return Math.max(percentSimilarity, 0).toFixed(0)
        }
    }

    const category = document.querySelector('#category')

    if (category) {
        const allImg = category.querySelectorAll('IMG')

        allImg.forEach(img => {
            resize(img)
        })
    }

    const crudCategory = document.querySelector('#crud-category')

    if (crudCategory) {
        img = crudCategory.querySelector('img')
        titleImg = crudCategory.querySelector('.title-img')
        textImg = crudCategory.querySelector('.text-img')
        inputFile = crudCategory.querySelector('.image-category input')

        crudCategory.addEventListener('change', (e) => {
            if (e.target.type == 'file') {
                if (e.target.files[0]) {
                    if (img.classList.contains('no-src')) { img.classList.remove('no-src') }

                    img.src = URL.createObjectURL(e.target.files[0])
                    titleImg.textContent = 'Imágen agregada'
                    textImg.textContent = e.target.files[0].name
                    resizeOnLoad(img)
                } else {
                    if (!img.classList.contains('no-src')) { img.classList.add('no-src') }

                    img.src = ''
                    titleImg.textContent = 'Sin imagen'
                    textImg.textContent = '...'
                }
            }
        })

        crudCategory.addEventListener('click', (e) => {
            if (e.target.classList.contains('remove-img')) {
                if (!img.classList.contains('no-src')) { img.classList.add('no-src') }

                img.src = ''
                titleImg.textContent = 'Sin imagen'
                textImg.textContent = '...'
                e.target.closest('.image-category').querySelector('input').value = ''
            }

            if (e.target.tagName == 'BUTTON' && e.target.name) {
                e.preventDefault()

                var formData = new FormData(crudCategory)
                formData.append(e.target.name, true)

                $.ajax({
                    url: '?ajax=categoria&&func=crud',
                    data: formData,
                    type: 'POST',
                    processData: false,
                    contentType: false,

                    success: function (html) {
                        $('.alert').html(html)
                    }
                })
            }
        })
    }

    function resize(img) {
        const width = img.getBoundingClientRect().width
        const height = img.getBoundingClientRect().height

        if (height > width) {
            img.parentNode.classList.add('height')
        } else {
            img.parentNode.classList.remove('height')
        }
    }

    function resizeOnLoad(img) {
        img.onload = function () {
            const width = img.getBoundingClientRect().width
            const height = img.getBoundingClientRect().height

            if (height > width) {
                img.parentNode.classList.add('height')
            } else {
                img.parentNode.classList.remove('height')
            }
        }
    }

    const paperBin = document.querySelector('#paperBin')

    if (paperBin) {
        allCheckbox = paperBin.querySelectorAll('tbody input[type="checkbox"]')
        allButton = paperBin.querySelectorAll('tfoot button')
        checksAll = paperBin.querySelector('.all-checks input')

        paperBin.addEventListener('click', (e) => {
            if (e.target.type == 'checkbox') {
                check = e.target

                existChecked = paperBin.querySelector('tbody input:not(:checked)')
                boolean = existChecked ? true : false

                if (check.parentNode.classList.contains('all-checks')) {
                    allCheckbox.forEach(checkbox => {
                        checkbox.checked = boolean
                    })
                }

                bool = true

                allCheckbox.forEach(checkbox => {
                    if (checkbox.checked == false) {
                        bool = false
                    }
                })

                oneChecked = paperBin.querySelector('tbody input:checked')
                checksAll.checked = bool

                allButton.forEach(button => {
                    if (oneChecked) {
                        button.removeAttribute('disabled')
                    } else {
                        button.setAttribute('disabled', true)
                    }
                })
            }
        })
    }
})
