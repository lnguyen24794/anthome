/**
 * AJAX Price Filter for WooCommerce
 * 
 * @package Anthome
 */

(function($) {
    'use strict';

    // Price Filter Handler
    class PriceFilter {
        constructor() {
            this.minPrice = 0;
            this.maxPrice = 5000000;
            this.init();
        }

        init() {
            this.setupSliders();
            this.bindEvents();
        }

        setupSliders() {
            const minSlider = $('#price-min');
            const maxSlider = $('#price-max');
            const minInput = $('#min-price-input');
            const maxInput = $('#max-price-input');

            if (minSlider.length && maxSlider.length) {
                // Get initial values from URL if exists
                const urlParams = new URLSearchParams(window.location.search);
                const minPriceParam = urlParams.get('min_price');
                const maxPriceParam = urlParams.get('max_price');

                if (minPriceParam) {
                    this.minPrice = parseInt(minPriceParam);
                    minSlider.val(this.minPrice);
                    minInput.val(this.minPrice);
                }

                if (maxPriceParam) {
                    this.maxPrice = parseInt(maxPriceParam);
                    maxSlider.val(this.maxPrice);
                    maxInput.val(this.maxPrice);
                }

                // Update display
                this.updatePriceDisplay();
            }
        }

        bindEvents() {
            const self = this;

            // Min price slider change
            $('#price-min').on('input', function() {
                self.minPrice = parseInt($(this).val());
                
                // Don't let min exceed max
                if (self.minPrice > self.maxPrice) {
                    self.minPrice = self.maxPrice;
                    $(this).val(self.minPrice);
                }
                
                self.updatePriceDisplay();
            });

            // Max price slider change
            $('#price-max').on('input', function() {
                self.maxPrice = parseInt($(this).val());
                
                // Don't let max go below min
                if (self.maxPrice < self.minPrice) {
                    self.maxPrice = self.minPrice;
                    $(this).val(self.maxPrice);
                }
                
                self.updatePriceDisplay();
            });

            // Min price input change
            $('#min-price-input').on('change', function() {
                let value = parseInt($(this).val()) || 0;
                
                // Validate range
                if (value < 0) value = 0;
                if (value > 5000000) value = 5000000;
                if (value > self.maxPrice) value = self.maxPrice;
                
                self.minPrice = value;
                $(this).val(value);
                $('#price-min').val(value);
                self.updatePriceDisplay();
            });

            // Max price input change
            $('#max-price-input').on('change', function() {
                let value = parseInt($(this).val()) || 5000000;
                
                // Validate range
                if (value < 0) value = 0;
                if (value > 5000000) value = 5000000;
                if (value < self.minPrice) value = self.minPrice;
                
                self.maxPrice = value;
                $(this).val(value);
                $('#price-max').val(value);
                self.updatePriceDisplay();
            });

            // Apply filter button
            $('#apply-price-filter').on('click', function(e) {
                e.preventDefault();
                self.applyFilter();
            });

            // Reset filter button
            $('#reset-price-filter').on('click', function(e) {
                e.preventDefault();
                self.resetFilter();
            });

            // Enter key on input fields
            $('#min-price-input, #max-price-input').on('keypress', function(e) {
                if (e.which === 13) {
                    e.preventDefault();
                    $(this).trigger('change');
                    self.applyFilter();
                }
            });

            // Collapse chevron rotation
            $('.filter-toggle').on('click', function() {
                $(this).find('.bi-chevron-down').toggleClass('rotate-180');
            });
        }

        updatePriceDisplay() {
            // Update input fields
            $('#min-price-input').val(this.minPrice);
            $('#max-price-input').val(this.maxPrice);
            
            // Update progress bar
            this.updateProgressBar();
        }

        updateProgressBar() {
            const minPercent = (this.minPrice / 5000000) * 100;
            const maxPercent = (this.maxPrice / 5000000) * 100;
            
            $('.price-progress').css({
                'left': minPercent + '%',
                'right': (100 - maxPercent) + '%'
            });
        }

        applyFilter() {
            const currentUrl = new URL(window.location.href);
            const params = new URLSearchParams(currentUrl.search);
            
            // Update URL parameters
            params.set('min_price', this.minPrice);
            params.set('max_price', this.maxPrice);
            
            // Remove paged parameter when filtering
            params.delete('paged');
            
            // Show loading state
            this.showLoading();
            
            // Build new URL
            const newUrl = currentUrl.pathname + '?' + params.toString();
            
            // Use AJAX to load products
            this.loadProducts(newUrl);
        }

        resetFilter() {
            this.minPrice = 0;
            this.maxPrice = 5000000;
            
            $('#price-min').val(this.minPrice);
            $('#price-max').val(this.maxPrice);
            $('#min-price-input').val(this.minPrice);
            $('#max-price-input').val(this.maxPrice);
            
            this.updatePriceDisplay();
            
            // Remove price parameters from URL
            const currentUrl = new URL(window.location.href);
            const params = new URLSearchParams(currentUrl.search);
            params.delete('min_price');
            params.delete('max_price');
            params.delete('paged');
            
            const newUrl = params.toString() ? 
                currentUrl.pathname + '?' + params.toString() : 
                currentUrl.pathname;
            
            // Show loading state
            this.showLoading();
            
            // Use AJAX to load products
            this.loadProducts(newUrl);
        }

        loadProducts(url) {
            const self = this;
            
            $.ajax({
                url: url,
                type: 'GET',
                dataType: 'html',
                success: function(response) {
                    // Extract products container
                    const $response = $(response);
                    const $newProducts = $response.find('.row.g-4').first();
                    const $newPagination = $response.find('.woocommerce-pagination');
                    const $newResultCount = $response.find('.woocommerce-result-count');
                    
                    // Update products
                    if ($newProducts.length) {
                        $('.row.g-4').first().html($newProducts.html());
                    }
                    
                    // Update pagination
                    if ($newPagination.length) {
                        $('.woocommerce-pagination').replaceWith($newPagination);
                    } else {
                        $('.woocommerce-pagination').remove();
                    }
                    
                    // Update result count
                    if ($newResultCount.length) {
                        $('.woocommerce-result-count').replaceWith($newResultCount);
                    }
                    
                    // Update URL without reload
                    window.history.pushState({}, '', url);
                    
                    // Hide loading
                    self.hideLoading();
                    
                    // Scroll to products
                    $('html, body').animate({
                        scrollTop: $('.row.g-4').first().offset().top - 100
                    }, 300);
                    
                    // Trigger custom event
                    $(document).trigger('anthome_products_filtered');
                },
                error: function() {
                    // If AJAX fails, do normal page reload
                    window.location.href = url;
                }
            });
        }

        showLoading() {
            // Add loading overlay
            if (!$('.products-loading-overlay').length) {
                $('.row.g-4').first().css('position', 'relative').append(
                    '<div class="products-loading-overlay">' +
                        '<div class="spinner-border text-primary" role="status">' +
                            '<span class="visually-hidden">Đang tải...</span>' +
                        '</div>' +
                    '</div>'
                );
            }
            
            // Disable filter button
            $('#apply-price-filter').prop('disabled', true).html(
                '<span class="spinner-border spinner-border-sm me-2"></span>Đang lọc...'
            );
        }

        hideLoading() {
            $('.products-loading-overlay').remove();
            $('#apply-price-filter').prop('disabled', false).html(
                '<i class="bi bi-funnel me-1"></i>Lọc'
            );
        }
    }

    // Initialize when DOM is ready
    $(document).ready(function() {
        // Only initialize if price filter exists
        if ($('#price-min').length && $('#price-max').length) {
            new PriceFilter();
        }
    });

})(jQuery);

