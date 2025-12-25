// |--------------------------------------------------------------------------
// | Order's Index Page
// |--------------------------------------------------------------------------

    // All Tables
    const allButton = document.querySelector('#allButton');
    const allContent = document.querySelector('#allContent');

    // Uncompleted Orders
    const uncompletedButton = document.querySelector('#uncompletedButton');
    const uncompletedContent = document.querySelector('#uncompletedContent');

    // Completed Orders
    const completedButton = document.querySelector('#completedButton');
    const completedContent = document.querySelector('#completedContent');

    // Finished Orders
    const finishedButton = document.querySelector('#finishedButton');
    const finishedContent = document.querySelector('#finishedContent');

    // Function to reset button styles
    function resetButtonStyles() {
        // Reset all buttons to default style
        if (allButton) {
            allButton.classList.remove('bg-primary', 'text-white');
            allButton.classList.add('bg-white', 'dark:bg-card-dark', 'text-primary', 'border-2', 'border-primary');
        }
        if (uncompletedButton) {
            uncompletedButton.classList.remove('bg-orange-600', 'text-white');
            uncompletedButton.classList.add('bg-white', 'dark:bg-card-dark', 'text-orange-600', 'dark:text-orange-400', 'border-2', 'border-orange-500');
        }
        if (completedButton) {
            completedButton.classList.remove('bg-blue-600', 'text-white');
            completedButton.classList.add('bg-white', 'dark:bg-card-dark', 'text-blue-600', 'dark:text-blue-400', 'border-2', 'border-blue-500');
        }
        if (finishedButton) {
            finishedButton.classList.remove('bg-green-600', 'text-white');
            finishedButton.classList.add('bg-white', 'dark:bg-card-dark', 'text-green-600', 'dark:text-green-400', 'border-2', 'border-green-500');
        }
    }

    // Function to set active button style
    function setActiveButton(button) {
        if (!button) return;
        
        resetButtonStyles();
        
        if (button.id === 'allButton') {
            button.classList.remove('bg-white', 'dark:bg-card-dark', 'text-primary', 'border-2', 'border-primary');
            button.classList.add('bg-primary', 'text-white');
        } else if (button.id === 'uncompletedButton') {
            button.classList.remove('bg-white', 'dark:bg-card-dark', 'text-orange-600', 'dark:text-orange-400', 'border-2', 'border-orange-500');
            button.classList.add('bg-orange-600', 'text-white');
        } else if (button.id === 'completedButton') {
            button.classList.remove('bg-white', 'dark:bg-card-dark', 'text-blue-600', 'dark:text-blue-400', 'border-2', 'border-blue-500');
            button.classList.add('bg-blue-600', 'text-white');
        } else if (button.id === 'finishedButton') {
            button.classList.remove('bg-white', 'dark:bg-card-dark', 'text-green-600', 'dark:text-green-400', 'border-2', 'border-green-500');
            button.classList.add('bg-green-600', 'text-white');
        }
    }

    // All Tables
    allButton.addEventListener('click', () => {
        // Show all content
        allContent.classList.remove('hidden');
        uncompletedContent.classList.add('hidden');
        completedContent.classList.add('hidden');
        if (finishedContent) finishedContent.classList.add('hidden');

        // Update button styles
        resetButtonStyles();
        setActiveButton(allButton);

        // Trigger search to refresh filtered results
        setTimeout(() => {
            if (typeof performSearch === 'function') {
                performSearch();
            }
        }, 100);

        // Remove filter parameter
        const currentUrl = new URL(window.location.href);
        currentUrl.searchParams.delete('filter');
        window.location.href = currentUrl.toString();
    });

    // Uncompleted Orders
    uncompletedButton.addEventListener('click', () => {
        // Show uncompleted content
        allContent.classList.add('hidden');
        uncompletedContent.classList.remove('hidden');
        completedContent.classList.add('hidden');
        if (finishedContent) finishedContent.classList.add('hidden');

        // Update button styles
        resetButtonStyles();
        setActiveButton(uncompletedButton);

        // Trigger search to refresh filtered results
        setTimeout(() => {
            if (typeof performSearch === 'function') {
                performSearch();
            }
        }, 100);
    });

    // Completed Orders
    completedButton.addEventListener('click', () => {
        // Show completed content
        allContent.classList.add('hidden');
        uncompletedContent.classList.add('hidden');
        completedContent.classList.remove('hidden');
        if (finishedContent) finishedContent.classList.add('hidden');

        // Update button styles
        resetButtonStyles();
        setActiveButton(completedButton);

        // Trigger search to refresh filtered results
        setTimeout(() => {
            if (typeof performSearch === 'function') {
                performSearch();
            }
        }, 100);
    });

    // Finished Orders
    if (finishedButton && finishedContent) {
        finishedButton.addEventListener('click', () => {
            // Reload page with filter parameter to get completed orders
            const currentUrl = new URL(window.location.href);
            currentUrl.searchParams.set('filter', 'completed');
            // Preserve date filter if exists
            const dateFilter = document.getElementById('dateFilter');
            if (dateFilter && dateFilter.value) {
                currentUrl.searchParams.set('date', dateFilter.value);
            }
            window.location.href = currentUrl.toString();
        });
    }