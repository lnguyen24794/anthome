/**
 * Product Search with AJAX
 * Enhanced live search functionality
 */

(function($) {
    'use strict';

    const ProductSearch = {
        init() {
            this.searchForms = $('.header-search-form');
            this.searchInputs = $('#product-search-input, #product-search-input-mobile');
            this.searchTimeout = null;
            this.minChars = 2;

            if (this.searchInputs.length) {
                this.bindEvents();
            }
        },

        bindEvents() {
            // Bind to each search input
            this.searchInputs.each((index, input) => {
                const $input = $(input);
                const $form = $input.closest('.header-search-form');
                const $category = $form.find('#product-search-category');
                
                // Create results container for this form
                if (!$form.find('.product-search-dropdown').length) {
                    $form.append('<div class="product-search-dropdown"></div>');
                }
                const $results = $form.find('.product-search-dropdown');

                // Input event for live search
                $input.on('input', (e) => {
                    clearTimeout(this.searchTimeout);
                    const query = $(e.target).val().trim();

                    if (query.length >= this.minChars) {
                        this.searchTimeout = setTimeout(() => {
                            this.performSearch(query, $form, $category, $results);
                        }, 300); // Debounce 300ms
                    } else {
                        this.hideResults($results, $input);
                    }
                });

                // Category change
                if ($category.length) {
                    $category.on('change', () => {
                        const query = $input.val().trim();
                        if (query.length >= this.minChars) {
                            this.performSearch(query, $form, $category, $results);
                        }
                    });
                }

                // Close results when clicking outside
                $(document).on('click', (e) => {
                    if (!$(e.target).closest($form).length) {
                        this.hideResults($results, $input);
                    }
                });

                // Form submit
                $form.on('submit', (e) => {
                    const query = $input.val().trim();
                    if (query.length < this.minChars) {
                        e.preventDefault();
                        this.showMessage('Vui lòng nhập ít nhất ' + this.minChars + ' ký tự', 'warning', $results);
                    }
                });

                // Keyboard navigation
                $input.on('keydown', (e) => {
                    if (e.key === 'Escape') {
                        this.hideResults($results, $input);
                    }
                });
            });
        },

        performSearch(query, $form, $category, $results) {
            this.showLoading($results);

            const category = $category.length ? $category.val() : '';

            $.ajax({
                url: anthomeSearch.ajaxurl,
                type: 'GET',
                data: {
                    action: 'anthome_product_search',
                    s: query,
                    category: category,
                    nonce: anthomeSearch.nonce
                },
                success: (response) => {
                    if (response.success) {
                        this.displayResults(response.data.results, response.data.count, query, $form, $results);
                    } else {
                        this.showMessage(response.data.message || 'Không tìm thấy sản phẩm', 'info', $results);
                    }
                },
                error: () => {
                    this.showMessage('Có lỗi xảy ra, vui lòng thử lại', 'error', $results);
                }
            });
        },

        displayResults(results, count, query, $form, $results) {
            if (!results || results.length === 0) {
                this.showMessage('Không tìm thấy sản phẩm nào', 'info', $results);
                return;
            }

            let html = '<div class="search-results-wrapper">';
            
            // Header
            html += '<div class="search-results-header">';
            html += '<span class="search-results-count">';
            html += '<i class="bi bi-search me-1"></i>';
            html += 'Tìm thấy <strong>' + count + '</strong> sản phẩm';
            html += '</span>';
            html += '<button type="button" class="search-close">';
            html += '<i class="bi bi-x-lg"></i>';
            html += '</button>';
            html += '</div>';

            // Results list
            html += '<ul class="search-results-list">';
            
            results.forEach((product) => {
                const stockClass = product.stock_status === 'instock' ? 'text-success' : 'text-danger';
                const stockText = product.stock_status === 'instock' ? 'Còn hàng' : 'Hết hàng';
                
                html += '<li class="search-result-item">';
                html += '<a href="' + product.url + '" class="search-result-link">';
                
                // Product image
                if (product.image) {
                    html += '<div class="search-result-image">';
                    html += '<img src="' + product.image + '" alt="' + product.title + '">';
                    html += '</div>';
                }
                
                // Product info
                html += '<div class="search-result-info">';
                html += '<h6 class="search-result-title">' + product.title + '</h6>';
                html += '<div class="search-result-meta">';
                html += '<span class="search-result-price">' + product.price + '</span>';
                html += '<span class="search-result-stock ' + stockClass + '">';
                html += '<i class="bi bi-circle-fill me-1" style="font-size: 0.5rem;"></i>';
                html += stockText;
                html += '</span>';
                html += '</div>';
                html += '</div>';
                
                html += '</a>';
                html += '</li>';
            });
            
            html += '</ul>';

            // Footer with view all link
            const shopUrl = $form.attr('action') || '/cua-hang/';
            html += '<div class="search-results-footer">';
            html += '<a href="' + shopUrl + '?s=' + encodeURIComponent(query) + '&post_type=product" class="btn btn-primary btn-sm w-100">';
            html += 'Xem tất cả kết quả <i class="bi bi-arrow-right ms-2"></i>';
            html += '</a>';
            html += '</div>';
            
            html += '</div>';

            $results.html(html);
            this.showResults($results, $form.find('input[type="search"]'));
            
            // Bind close button
            $results.find('.search-close').on('click', () => {
                this.hideResults($results, $form.find('input[type="search"]'));
            });
        },

        showLoading($results) {
            const html = '<div class="search-results-loading">' +
                        '<div class="spinner-border spinner-border-sm text-primary me-2" role="status">' +
                        '<span class="visually-hidden">Loading...</span>' +
                        '</div>' +
                        'Đang tìm kiếm...' +
                        '</div>';
            $results.html(html);
            this.showResults($results);
        },

        showMessage(message, type = 'info', $results) {
            const iconMap = {
                'info': 'bi-info-circle',
                'warning': 'bi-exclamation-triangle',
                'error': 'bi-x-circle',
                'success': 'bi-check-circle'
            };

            const html = '<div class="search-results-message alert alert-' + type + '">' +
                        '<i class="bi ' + iconMap[type] + ' me-2"></i>' +
                        message +
                        '</div>';
            $results.html(html);
            this.showResults($results);
        },

        showResults($results, $input) {
            $results.slideDown(200);
            if ($input) {
                $input.addClass('search-active');
            }
        },

        hideResults($results, $input) {
            $results.slideUp(200);
            if ($input) {
                $input.removeClass('search-active');
            }
        }
    };

    // Initialize on document ready
    $(document).ready(() => {
        ProductSearch.init();
    });

})(jQuery);

