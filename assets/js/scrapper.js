/**
 * This function is executed when the DOM is ready.
 */
jQuery(document).ready(function ($) {
    // DOM elements
    const scrapeBtn = $('#scraper_button'); // Scrape button
    const scrapBtnLoader = $('#scrape_loader'); // Loader element
    const scrapperMessage = $('#scrapper_message'); // Message element
    const userQtyField = $('#users_qty'); // User quantity input field

    // Set a default value for user quantity
    userQtyField.val(8);

    /**
     * Event listener for the "Scrape" button click.
     */
    scrapeBtn.on('click', (e) => {
        e.preventDefault();
        const usersToScrape = userQtyField.val();
        sendAjaxRequest(usersToScrape);
    });

    /**
     * Send an AJAX request to scrape GitHub users.
     *
     * @param {number} userQty - The number of users to scrape.
     */
    const sendAjaxRequest = (userQty) => {
        $.ajax({
            url: data_obj.ajax_url,
            type: 'POST',
            data: {
                action: 'github_scraper',
                user_qty: userQty
            },
            beforeSend: function () {
                showOnScreen(scrapBtnLoader);
                $('#github_users_grid').html(""); // Clearing any previous grid
                showOnScreen(scrapperMessage);
                scrapperMessage.html("🕰️ Please wait while we scrape GitHub users for you");
            },
            success: function (res) {
                $('#github_users_grid').html(res);
            },
            complete: function () {
                hideFromScreen(scrapperMessage);
                hideFromScreen(scrapBtnLoader);
            }
        });
    };

    /**
     * Show an element on the screen.
     *
     * @param {jQuery} element - The element to show.
     */
    const showOnScreen = (element) => {
        element.removeClass('hidden');
    };

    /**
     * Hide an element from the screen.
     *
     * @param {jQuery} element - The element to hide.
     */
    const hideFromScreen = (element) => {
        element.addClass('hidden');
    };
});
