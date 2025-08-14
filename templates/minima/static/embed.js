$(document).ready(function(){initTheme();initSearch();initBookmarks();initScrollEffects();initCategoryNav();});

/**
 * Initialize theme functionality
 */
function initTheme() {
    // Initialize tooltips
    $('[data-toggle="tooltip"]').tooltip();
    
    // Handle mobile menu
    $('.navbar-toggler').on('click', function() {
        $('body').toggleClass('menu-open');
    });
}

/**
 * Initialize search functionality
 */
function initSearch() {
    const $input = $('#searchInput');
    const $suggest = $('#searchSuggestions');
    const $clear = $('#clearSearch');
    let timer;
    
    // Search input handler
    $input.on('input', function() {
        const q = this.value.toLowerCase().trim();
        
        clearTimeout(timer);
        timer = setTimeout(() => performSearch(q), 220);
        
        if (!q) {
            $clear.hide();
        } else {
            $clear.show();
        }
    });
    
    // Clear search on escape
    $input.on('keydown', e => {
        if (e.key === 'Escape') {
            clearSearch();
        }
    });
    
    // Clear button click
    $clear.on('click', () => {
        clearSearch();
        $input.focus();
    });
    
    // Hide suggestions when clicking outside
    $(document).on('click', function(e) {
        if (!$(e.target).closest('.search-container').length) {
            $suggest.hide();
        }
    });
    
    // Focus search with Ctrl+K or Cmd+K
    $(document).on('keydown', function(e) {
        if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
            e.preventDefault();
            $input.focus();
        }
    });
}

/**
 * Perform search and show results
 */
function performSearch(query) {
    const searchSuggestions = $('#searchSuggestions');
    
    if (!query) {
        clearSearch();
        return;
    }
    
    const bookmarks = $('.bookmark-card').not('.more-card');
    const matches = [];
    
    bookmarks.each(function() {
        const $card = $(this);
        const title = $card.data('title') || '';
        const url = $card.data('url') || '';
        const description = $card.data('description') || '';
        const searchText = (title + ' ' + url + ' ' + description).toLowerCase();
        if (searchText.includes(query)) {
            matches.push({
                element: $card,
                title: title,
                url: url,
                description: description,
                score: calculateSearchScore(query, title, url, description)
            });
        }
    });
    matches.sort((a, b) => b.score - a.score);
    displaySearchResults(matches, query); // 仅展示建议，不再过滤主列表
}

/**
 * Calculate search relevance score
 */
function calculateSearchScore(query, title, url, description) {
    let score = 0;
    const lowerQuery = query.toLowerCase();
    const lowerTitle = title.toLowerCase();
    const lowerUrl = url.toLowerCase();
    const lowerDesc = description.toLowerCase();
    
    // Title matches are most important
    if (lowerTitle.includes(lowerQuery)) {
        score += 10;
        if (lowerTitle.startsWith(lowerQuery)) score += 5;
    }
    
    // URL matches
    if (lowerUrl.includes(lowerQuery)) {
        score += 5;
    }
    
    // Description matches
    if (lowerDesc.includes(lowerQuery)) {
        score += 2;
    }
    
    return score;
}

/**
 * Display search suggestions
 */
function displaySearchResults(matches, query) {
    const searchSuggestions = $('#searchSuggestions');
    if (matches.length === 0) {
        searchSuggestions.html('<div class="search-suggestion-item empty text-muted">没有找到匹配的书签</div>').show();
        return;
    }
    let html = '';
    matches.slice(0, 5).forEach(match => { // 限制最多 5 条
        const highlightedTitle = highlightText(match.title, query);
        const domain = extractDomain(match.url);
        html += `
            <div class="search-suggestion-item" data-url="${match.url}" title="${match.title}">
                <div class="ss-icon">
                    <img src="/index.php?c=ico&text=${encodeURIComponent(match.title)}" width="28" height="28" alt="${match.title}">
                </div>
                <div class="ss-meta">
                    <div class="ss-title">${highlightedTitle}</div>
                    <div class="ss-domain">${domain}</div>
                </div>
            </div>`;
    });
    searchSuggestions.html(html).show();
    $('.search-suggestion-item').off('click').on('click', function() {
        const url = $(this).data('url');
        if (url) window.open(url, '_blank');
    });
}

/**
 * Highlight text matches
 */
function highlightText(text, query) {
    if (!query) return text;
    
    const regex = new RegExp(`(${escapeRegex(query)})`, 'gi');
    return text.replace(regex, '<span class="search-highlight">$1</span>');
}

/**
 * Escape regex special characters
 */
function escapeRegex(string) {
    return string.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
}

/**
 * Extract domain from URL
 */
function extractDomain(url) {
    try {
        return new URL(url).hostname;
    } catch {
        return url;
    }
}

/**
 * Clear search results
 */
function clearSearch() {
    $('#searchInput').val('');
    $('#searchSuggestions').hide().empty();
}

/**
 * Update category counts
 */
function updateCategoryCounts() {
    $('.category-section').each(function() {
        const $section = $(this);
        const visibleCount = $section.find('.bookmark-card:not(.d-none):not(.more-card)').length;
        $section.find('.badge').text(visibleCount);
    });
}

/**
 * Initialize bookmark interactions
 */
function initBookmarks() {
    // Copy link functionality
    $(document).on('click', '.copy-link', function(e) {
        e.preventDefault();
        e.stopPropagation();
        
        const url = $(this).data('url');
        copyToClipboard(url);
        showToast('链接已复制', 'success');
    });
    
    // QR code functionality
    $(document).on('click', '.qr-code', function(e) {
        e.preventDefault();
        e.stopPropagation();
        
        const url = $(this).data('url');
        showQRCode(url);
    });
    
    // Add link functionality (for logged-in users)
    $('#addLinkBtn').on('click', function() {
        window.open('/index.php?c=admin&page=add_link', '_blank');
    });
}

/**
 * Copy text to clipboard
 */
function copyToClipboard(text) {
    if (navigator.clipboard && window.isSecureContext) {
        navigator.clipboard.writeText(text);
    } else {
        const textArea = document.createElement('textarea');
        textArea.value = text;
        textArea.style.position = 'fixed';
        textArea.style.left = '-999999px';
        textArea.style.top = '-999999px';
        document.body.appendChild(textArea);
        textArea.focus();
        textArea.select();
        document.execCommand('copy');
        textArea.remove();
    }
}

/**
 * Show QR code modal
 */
function showQRCode(url) {
    $('#qrcode').empty();
    $('#qrUrl').text(url);
    
    try {
        // 使用 qrcode.min.js 库（QRCode 构造函数）
        const qrobj = new QRCode('qrcode', {
            text: url,
            width: 180,
            height: 180,
            colorDark: '#1f2937',
            colorLight: '#ffffff',
            correctLevel: QRCode.CorrectLevel.H
        });
    } catch (e) {
        $('#qrcode').html('<p class="text-muted">二维码生成失败</p>');
    }
    
    $('#qrModal').modal('show');
}

/**
 * Show simple toast notification
 */
function showToast(message, type = 'info') {
    const toastId = 'toast-' + Date.now();
    const alertClass = type === 'success' ? 'alert-success' : 
                      type === 'error' ? 'alert-danger' : 'alert-info';
    
    const toast = $(`
        <div id="${toastId}" class="alert ${alertClass} alert-dismissible fade show position-fixed" 
             style="top: 100px; right: 20px; z-index: 9999; min-width: 250px;">
            ${message}
            <button type="button" class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>
        </div>
    `);
    
    $('body').append(toast);
    
    // Auto remove after 2 seconds
    setTimeout(() => {
        $(`#${toastId}`).alert('close');
    }, 2000);
}

/**
 * Initialize scroll effects
 */
function initScrollEffects() {
    const $backToTop = $('#backToTop');
    
    // Back to top button
    $(window).on('scroll', function() {
        if ($(this).scrollTop() > 300) {
            $backToTop.addClass('show');
        } else {
            $backToTop.removeClass('show');
        }
    });
    
    // Back to top click
    $backToTop.on('click', function() {
        $('html, body').animate({
            scrollTop: 0
        }, 500);
    });
}

/**
 * Initialize category navigation
 */
function initCategoryNav() {
    const $tabs = $('#categoryTabs .nav-link');
    const $scroll = $('#categoryScroll');
    
    // Handle category tab clicks
    $tabs.on('click', function(e) {
        e.preventDefault();
        
        const $t = $(this);
        const cat = $t.data('category');
        
        // Update active tab
        $tabs.removeClass('active');
        $t.addClass('active');
        
        // Filter categories
        if (cat === 'all') {
            $('.category-section').show();
        } else {
            $('.category-section').hide();
            $('#category-' + cat).show();
        }
        
        // 计算当前tab在容器中的位置，自动滚动使其尽量居中
        const tabEl = this;
        const container = $scroll.get(0);
        const cRect = container.getBoundingClientRect();
        const tRect = tabEl.getBoundingClientRect();
        const offset = (tRect.left - cRect.left) - (cRect.width / 2 - tRect.width / 2);
        container.scrollBy({ left: offset, behavior: 'smooth' });
    });
}

/**
 * 删除 initCategoryNavArrows 相关调用后保留函数引用以防外部依赖（可选保留空）
 */
function initCategoryNavArrows(){}

// 重新初始化分类箭头（防止某些情况下未绑定）
$(function(){
  if(typeof initCategoryNavArrows==='function'){
    initCategoryNavArrows();
  }
});

/**
 * Initialize scrollable category tabs
 */
function initScrollableCategoryTabs(){
  var $wrap = $('#catTabsScrollWrap');
  if(!$wrap.length) return;
  var $inner = $('#catScrollInner');
  var $prev = $('#catScrollPrev');
  var $next = $('#catScrollNext');
  function maxScroll(){return $inner[0].scrollWidth - $inner[0].clientWidth;}
  function update(){var sl=$inner.scrollLeft();var max=maxScroll();$prev.prop('disabled',sl<=2);$next.prop('disabled',sl>=max-2||max<=0);if(max<=0){$prev.hide();$next.hide();}else{$prev.show();$next.show();}}
  function smoothTo(target){var start=$inner.scrollLeft();var max=maxScroll();target=Math.max(0,Math.min(target,max));if(Math.abs(target-start)<2){$inner.scrollLeft(target);update();return;}var dur=360;var t0=null;function step(ts){if(!t0)t0=ts;var p=Math.min(1,(ts-t0)/dur);var ease=1-Math.pow(1-p,3);var cur=start+(target-start)*ease;$inner.scrollLeft(cur);if(p<1)requestAnimationFrame(step);else update();}requestAnimationFrame(step);} 
  function stepSize(){return Math.max(120,Math.round($inner.width()*0.55));}
  $prev.on('click',function(){smoothTo($inner.scrollLeft()-stepSize());});
  $next.on('click',function(){smoothTo($inner.scrollLeft()+stepSize());});
  $inner.on('scroll',update);
  $(window).on('resize',update);
  update();
  // 居中当前激活项（首次）
  var $active=$inner.find('.nav-link.active');
  if($active.length){var left=$active.position().left;var target=left-($inner.width()-$active.outerWidth())/2;smoothTo(target);} 
  // 点击自动居中
  $inner.on('click','.nav-link',function(){var left=$(this).position().left;var target=left-($inner.width()-$(this).outerWidth())/2;smoothTo(target);});
}
$(document).ready(function(){initScrollableCategoryTabs();});

/**
 * Handle responsive layout changes
 */
function handleResponsiveLayout() {
    // Any responsive adjustments can be added here
    // Currently handled by CSS Grid
}

// Handle window resize
$(window).on('resize', handleResponsiveLayout);

// Initialize responsive layout on load
handleResponsiveLayout();
