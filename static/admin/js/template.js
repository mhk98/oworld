(function ($) {
    "use strict";
    $(function () {
        var body = $("body");
        var mainWrapper = $(".main-wrapper");
        var footer = $("footer");
        var sidebar = $(".sidebar");
        var navbar = $(".navbar").not(".top-navbar");

        // Enable feather-icons with SVG markup
        feather.replace();

        // initialize clipboard plugin
        if ($(".btn-clipboard").length) {
            // Enabling tooltip to all clipboard buttons
            $(".btn-clipboard")
                .attr("data-bs-toggle", "tooltip")
                .attr("title", "Copy to clipboard");

            var clipboard = new ClipboardJS(".btn-clipboard");

            clipboard.on("success", function (e) {
                console.log(e);
                e.trigger.innerHTML = "copied";
                setTimeout(function () {
                    e.trigger.innerHTML = "copy";
                    e.clearSelection();
                }, 700);
            });
        }

        // initializing bootstrap tooltip
        var tooltipTriggerList = [].slice.call(
            document.querySelectorAll('[data-bs-toggle="tooltip"]')
        );
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        // initializing bootstrap popover
        var popoverTriggerList = [].slice.call(
            document.querySelectorAll('[data-bs-toggle="popover"]')
        );
        var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
            return new bootstrap.Popover(popoverTriggerEl);
        });

        // Applying perfect-scrollbar
        if ($(".sidebar .sidebar-body").length) {
            const sidebarBodyScroll = new PerfectScrollbar(".sidebar-body");
        }

        // Sidebar toggle to sidebar-folded
        $(".sidebar-toggler").on("click", function (e) {
            e.preventDefault();
            $(".sidebar-header .sidebar-toggler").toggleClass(
                "active not-active"
            );
            if (window.matchMedia("(min-width: 992px)").matches) {
                e.preventDefault();
                body.toggleClass("sidebar-folded");
            } else if (window.matchMedia("(max-width: 991px)").matches) {
                e.preventDefault();
                body.toggleClass("sidebar-open");
            }
        });

        //  open sidebar-folded when hover
        $(".sidebar .sidebar-body").hover(
            function () {
                if (body.hasClass("sidebar-folded")) {
                    body.addClass("open-sidebar-folded");
                }
            },
            function () {
                if (body.hasClass("sidebar-folded")) {
                    body.removeClass("open-sidebar-folded");
                }
            }
        );

        // close sidebar when click outside on mobile/table
        $(document).on("click touchstart", function (e) {
            e.stopPropagation();

            // closing of sidebar menu when clicking outside of it
            if (!$(e.target).closest(".sidebar-toggler").length) {
                var sidebar = $(e.target).closest(".sidebar").length;
                var sidebarBody = $(e.target).closest(".sidebar-body").length;
                if (!sidebar && !sidebarBody) {
                    if ($("body").hasClass("sidebar-open")) {
                        $("body").removeClass("sidebar-open");
                    }
                }
            }
        });

        //Horizontal menu in mobile
        $('[data-toggle="horizontal-menu-toggle"]').on("click", function () {
            $(".horizontal-menu .bottom-navbar").toggleClass("header-toggled");
        });
        // Horizontal menu navigation in mobile menu on click
        var navItemClicked = $(".horizontal-menu .page-navigation >.nav-item");
        navItemClicked.on("click", function (event) {
            if (window.matchMedia("(max-width: 991px)").matches) {
                if (!$(this).hasClass("show-submenu")) {
                    navItemClicked.removeClass("show-submenu");
                }
                $(this).toggleClass("show-submenu");
            }
        });

        $(window).scroll(function () {
            if (window.matchMedia("(min-width: 992px)").matches) {
                var header = $(".horizontal-menu");
                if ($(window).scrollTop() >= 60) {
                    $(header).addClass("fixed-on-scroll");
                } else {
                    $(header).removeClass("fixed-on-scroll");
                }
            }
        });

        // Prevent body scrolling while sidebar scroll
        $(".sidebar .sidebar-body").hover(
            function () {
                $("body").addClass("overflow-hidden");
            },
            function () {
                $("body").removeClass("overflow-hidden");
            }
        );
    });
})(jQuery);
