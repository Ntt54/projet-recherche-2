// ===================================
// URAIA - Filtres et Recherche
// ===================================

document.addEventListener('DOMContentLoaded', function() {
    
    // Live Search Filter
    const searchInputs = document.querySelectorAll('[data-search-target]');
    searchInputs.forEach(input => {
        input.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const targetSelector = this.getAttribute('data-search-target');
            const items = document.querySelectorAll(targetSelector);
            
            items.forEach(item => {
                const text = item.textContent.toLowerCase();
                if (text.includes(searchTerm)) {
                    item.style.display = '';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    });
    
    // Category/Team Filter
    const filterButtons = document.querySelectorAll('[data-filter]');
    filterButtons.forEach(button => {
        button.addEventListener('click', function() {
            const filterValue = this.getAttribute('data-filter');
            const targetContainer = this.getAttribute('data-target') || '.filter-container';
            const items = document.querySelectorAll(`${targetContainer} [data-category]`);
            
            // Update active button
            filterButtons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');
            
            // Filter items
            items.forEach(item => {
                const category = item.getAttribute('data-category');
                if (filterValue === 'all' || category === filterValue) {
                    item.style.display = '';
                    item.style.opacity = '1';
                    item.style.transform = 'scale(1)';
                } else {
                    item.style.display = 'none';
                    item.style.opacity = '0';
                    item.style.transform = 'scale(0.8)';
                }
            });
        });
    });
    
    // Date Range Filter
    const dateFilters = document.querySelectorAll('.date-filter');
    dateFilters.forEach(filter => {
        filter.addEventListener('change', function() {
            const form = this.closest('form');
            if (form) {
                form.submit();
            }
        });
    });
    
    // Sort Functionality
    const sortSelects = document.querySelectorAll('[data-sort]');
    sortSelects.forEach(select => {
        select.addEventListener('change', function() {
            const sortBy = this.value;
            const targetContainer = this.getAttribute('data-sort-target') || '.sort-container';
            const items = Array.from(document.querySelectorAll(`${targetContainer} [data-sortable]`));
            
            items.sort((a, b) => {
                let aVal = a.getAttribute('data-' + sortBy);
                let bVal = b.getAttribute('data-' + sortBy);
                
                // Try to convert to numbers
                const aNum = parseFloat(aVal);
                const bNum = parseFloat(bVal);
                
                if (!isNaN(aNum) && !isNaN(bNum)) {
                    return aNum - bNum;
                }
                
                // String comparison
                return aVal.localeCompare(bVal);
            });
            
            const container = document.querySelector(targetContainer);
            items.forEach(item => container.appendChild(item));
        });
    });
    
    // Pagination with AJAX (optional enhancement)
    const paginationLinks = document.querySelectorAll('.pagination a');
    paginationLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            // Can be enhanced with AJAX for smoother experience
            // For now, standard page navigation
        });
    });
    
    // Advanced Filter Toggle
    const advancedFilterToggle = document.getElementById('advanced-filter-toggle');
    const advancedFilterPanel = document.getElementById('advanced-filter-panel');
    
    if (advancedFilterToggle && advancedFilterPanel) {
        advancedFilterToggle.addEventListener('click', function() {
            advancedFilterPanel.classList.toggle('active');
            const icon = this.querySelector('i');
            if (advancedFilterPanel.classList.contains('active')) {
                icon.classList.remove('fa-chevron-down');
                icon.classList.add('fa-chevron-up');
            } else {
                icon.classList.remove('fa-chevron-up');
                icon.classList.add('fa-chevron-down');
            }
        });
    }
    
    // Reset Filters
    const resetFilterButtons = document.querySelectorAll('.reset-filters');
    resetFilterButtons.forEach(button => {
        button.addEventListener('click', function() {
            const form = this.closest('form');
            if (form) {
                form.reset();
                form.submit();
            }
        });
    });
    
    // Filter counter
    const filterInputs = document.querySelectorAll('.filter-input');
    const filterCounter = document.getElementById('filter-count');
    
    if (filterInputs.length > 0 && filterCounter) {
        filterInputs.forEach(input => {
            input.addEventListener('change', function() {
                const activeCount = Array.from(filterInputs).filter(i => i.value).length;
                filterCounter.textContent = activeCount;
                filterCounter.style.display = activeCount > 0 ? 'inline' : 'none';
            });
        });
    }
    
});
