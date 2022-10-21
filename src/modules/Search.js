import $ from 'jquery';

class Search {
    //describe/initiate our object
    constructor() {
        this.addSearchHtml();
        this.resultsDiv = $("#search-overlay__results");
        this.openButton = $(".js-search-trigger");
        this.closeButton = $(".search-overlay__close");
        this.searchOverlay = $(".search-overlay");
        this.isOverlayOpened = false;
        this.searchField = $("#search-term");
        this.typingTimer;
        this.isSpinnerVisible = false;
        this.previousValue;
        this.events(); //this line makes sure the event listeners get added to the page right away
    }

    //events
    events() {
        this.openButton.on("click", this.openOverlay.bind(this));
        this.closeButton.on("click", this.closeOverlay.bind(this)); //the .bind(this) method makes sure 'this' is not pointing to the currently selected html
        $(document).on("keydown", this.keyPressDispatcher.bind(this));
        this.searchField.on("keyup", this.typingLogic.bind(this));
    }

    //methods
    typingLogic() {
        if (this.searchField.val() != this.previousValue) {
            clearTimeout(this.typingTimer);
            if (this.searchField.val()) {
                if (!this.isSpinnerVisible) {
                    this.resultsDiv.html('<div class="spinner-loader"></div>');
                    this.isSpinnerVisible = true;
                }
                this.typingTimer = setTimeout(this.getResults.bind(this), 750);
            } 
            else {
                this.resultsDiv.html('');
                this.isSpinnerVisible = false;
            }  
        }
        this.previousValue = this.searchField.val();
    }

    getResults() {
        $.when(
        $.getJSON(universityData.root_url + '/wp-json/wp/v2/posts?search=' + this.searchField.val()),
        $.getJSON(universityData.root_url + '/wp-json/wp/v2/pages?search=' + this.searchField.val())
        ).then((posts, pages) => {
            var combinedResults = posts[0].concat(pages[0]); //we are combining two or more pages
            this.resultsDiv.html(`
            <h2 class="search-overlay__section-title">General Info</h2>
            ${combinedResults.length ? '<ul class="link-list min-list">' : '<p>No General Information is available.</p>'}
                ${combinedResults.map(item => `<li><a href="${item.link}">${item.title.rendered}</a> ${item.type == 'post' ? `by ${item.authorName}`: ''}
                
                </li>`).join('')}
            ${combinedResults.length ? '</ul>' : ''}
            `);
            this.isSpinnerVisible = false;
        },
        () => {
            this.resultsDiv.html('<p>Unexpected error.</p>');
        });
    }

    keyPressDispatcher(e) {
        // console.log(e.keyCode); // this will show us the keycode for each key we press
        if (this.isOverlayOpened && e.keyCode === 27) {
            this.searchOverlay.removeClass("search-overlay--active");
        }
    }

    openOverlay() {
        this.searchOverlay.addClass("search-overlay--active");
        $("body").addClass("body-no-scroll"); //this will add the attribute 'overflow hidden which will remove the ability to scroll
        this.searchField.val('');
        setTimeout(() => this.searchField.trigger('focus'), 301);
        this.isOverlayOpened = true;
    }

    closeOverlay() {
        this.searchOverlay.removeClass("search-overlay--active");
        $("body").removeClass("body-no-scroll");
    }

    addSearchHtml() {
        $("body").append(`
            <div class="search-overlay">
            <div class="search-overlay__top">
            <div class="container">
                <i class="fa fa-search search-overlay__icon" aria-hidden="true"></i>
                <input type="text" class="search-term" placeholder="What are you looking for?" id="search-term" autocomplete="off">
                <i class="fa fa-window-close search-overlay__close" aria-hidden="true"></i>
            </div>
            </div>
    
            <div class="container">
            <div id="search-overlay__results"></div>
            </div>
    
        </div>
        `);
    }
}

export default Search;