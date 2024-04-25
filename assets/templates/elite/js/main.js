(function ($) {
  "use strict";

  // ============== Header Hide Click On Body Js ========
  $('.header-button').on('click', function () {
    $('.body-overlay').toggleClass('show')
  });
  $('.body-overlay').on('click', function () {
    $('.header-button').trigger('click')
    $(this).removeClass('show');
  });

  // ==========================================
  //      Document Ready function Start
  // ==========================================
  $(document).ready(function () {

    // ========================== Header Hide Scroll Bar Js =====================
    $('.navbar-toggler.header-button').on('click', function () {
      $('body').toggleClass('scroll-hide-sm')
    });
    $('.body-overlay').on('click', function () {
      $('body').removeClass('scroll-hide-sm')
    });

    // ========================== add active class to current page Js =====================
    function dynamicActiveMenuClass(selector) {
      let FileName = window.location.href.split("/").reverse()[0];

      selector.find("li").each(function () {
        let anchor = $(this).find("a");
        if ($(anchor).attr("href") == FileName) {
          $(this).addClass("active");
        }
      });

      // if any li has active element add class
      selector.children("li").each(function () {
        if ($(this).find(".active").length) {
          $(this).addClass("active");
        }
      });

      // if no file name return
      if ("" == FileName) {
        selector.find("li").eq(0).addClass("active");
      }
    }
    if ($('ul').length) {
      dynamicActiveMenuClass($('ul'));
    }

    // ================== Password Show Hide Js ==========
    $(".toggle-password").on('click', function () {
      $(this).toggleClass(" fa-eye-slash");
      var input = $($(this).attr("id"));
      if (input.attr("type") == "password") {
        input.attr("type", "text");
      } else {
        input.attr("type", "password");
      }
    });

    // ===================== Table Delete Column Js =================
    $('.delete-icon').on('click', function () {
      $(this).closest('tr').addClass('d-none')
    });

    // ============================ToolTip =====================
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))

    // ================== Sidebar Dropdown Menu ===============
    $(".has-dropdown > a").click(function () {
      $(".sidebar-submenu").slideUp(200);
      if (
        $(this)
          .parent()
          .hasClass("active")
      ) {
        $(".has-dropdown").removeClass("active");
        $(this)
          .parent()
          .removeClass("active");
      } else {
        $(".has-dropdown").removeClass("active");
        $(this)
          .next(".sidebar-submenu")
          .slideDown(200);
        $(this)
          .parent()
          .addClass("active");
      }
    });

    // ========================= Dashboard Toggle Sidebar Js ===================
    $('.sidebar-toggle-btn').on('click', function () {
      $('.sidebar-menu').addClass('show');
      $('.sidebar-overlay').addClass('show');
      $('body').addClass('scroll-hide-sm');
    });
    $('.sidebar-menu__close, .sidebar-overlay').on('click', function () {
      $('.sidebar-menu').removeClass('show');
      $('.sidebar-overlay').removeClass('show');
      $('body').removeClass('scroll-hide-sm');
    });


    // ==================== Sidebar Icon & Overlay ==================
    $(".dashboard-body__bar-icon").on("click", function () {
      $(".sidebar-menu").addClass('show-sidebar');
      $(".sidebar-overlay").addClass('show');
    });
    $(".sidebar-menu__close, .sidebar-overlay").on("click", function () {
      $(".sidebar-menu").removeClass('show-sidebar');
      $(".sidebar-overlay").removeClass('show');
    });

    // ==================== Dashboard User Profile Dropdown ==================
    $('.user-info__button').on('click', function () {
      $('.user-info-dropdown').toggleClass('show');
    });
    $('.user-info__button').attr('tabindex', -1).focus();

    $('.user-info__button').on('focusout', function () {
      $('.user-info-dropdown').removeClass('show');
    });


    // ==================== PTable Tab Buttons ==================
    $(".buy-sell-tab__link.buy").on("click", function () {
      $(".buy-sell-tab__link.buy").addClass('active');
      $(".buy-sell-tab").removeClass('sell');
      $(".buy-sell-tab__link.sell").removeClass('active');
    });
    $(".buy-sell-tab__link.sell").on("click", function () {
      $(".buy-sell-tab__link.sell").addClass('active');
      $(".buy-sell-tab").addClass('sell');
      $(".buy-sell-tab__link.buy").removeClass('active');
    });


    // ==================== Buy & Sell Table Details ==================
    $(".table-btn").on("click", function () {
      $(".buy-details").toggleClass('show');
    });
    $(".buy-details__close").on("click", function () {
      $(".buy-details").removeClass('show');
    });

    // ==================== Header Right Items ==================

    // Wallet
    $('.wallet').on('click', function () {
      $('.wallet-list').toggleClass('show');
    });

    $(document).on('click', function (event) {
      var target = $(event.target);

      if (!target.closest('.wallet').length && !target.closest('.wallet-list').length) {
        $('.wallet-list').removeClass('show');
      }
    });

    // Notification
    $('.notification').on('click', function () {
      $('.notification-popup').toggleClass('show');
    });

    $(document).on('click', function (event) {
      var target = $(event.target);

      if (!target.closest('.notification').length && !target.closest('.notification-popup').length) {
        $('.notification-popup').removeClass('show');
      }
    });

    // Account
    $('.account').on('click', function () {
      $('.account-popup').toggleClass('show');
    });

    $(document).on('click', function (event) {
      var target = $(event.target);

      if (!target.closest('.account').length && !target.closest('.account-popup').length) {
        $('.account-popup').removeClass('show');
      }
    });

    // Language
    $('.language').on('click', function () {
      $('.language-list').toggleClass('show');
    });

    $(document).on('click', function (event) {
      var target = $(event.target);

      if (!target.closest('.language').length && !target.closest('.language-list').length) {
        $('.language-list').removeClass('show');
      }
    });




  });
  // ==========================================
  //      End Document Ready function
  // ==========================================


  // ==================== User Profile Dropdown ==================
  $('.ptable-header-right__link.dropdown').on('click', function () {
    $('.more-dropdown-list').toggleClass('show');
  });

  $(document).on('click', function (event) {
    var target = $(event.target);

    if (!target.closest('.ptable-header-right__link.dropdown').length && !target.closest('.more-dropdown-list').length) {
      $('.more-dropdown-list').removeClass('show');
    }
  });


  // ==================== Custom Dropdown Select ==================

  // Currency Switcher
  $('.currency_switcher > .currency_switcher__caption').on('click', function () {
    $(this).parent().toggleClass('open');
  });

  $('.currency_switcher > .currency_switcher__list > .currency_switcher__item').on('click', function () {
    $('.currency_switcher > .currency_switcher__list > .currency_switcher__item').removeClass('selected');
    $(this).addClass('selected').parent().parent().removeClass('open').children('.currency_switcher__caption').html($(this).html());
  });


  $(document).on('keyup', function (evt) {
    if ((evt.keyCode || evt.which) === 27) {
      $('.currency_switcher').removeClass('open');
    }
  });

  $(document).on('click', function (evt) {
    if ($(evt.target).closest(".currency_switcher > .currency_switcher__caption").length === 0) {
      $('.currency_switcher').removeClass('open');
    }
  });

  // Estimated Balance
  $('.eb_select > .eb_select__caption').on('click', function () {
    $(this).parent().toggleClass('open');
  });

  $('.eb_select > .eb_select__list > .eb_select__item').on('click', function () {
    $('.eb_select > .eb_select__list > .eb_select__item').removeClass('selected');
    $(this).addClass('selected').parent().parent().removeClass('open').children('.eb_select__caption').html($(this).html());

  });

  $(document).on('keyup', function (evt) {
    if ((evt.keyCode || evt.which) === 27) {
      $('.eb_select').removeClass('open');
    }
  });

  $(document).on('click', function (evt) {
    if ($(evt.target).closest(".eb_select > .eb_select__caption").length === 0) {
      $('.eb_select').removeClass('open');
    }
  });



  // ========================= Preloader Js =====================
  $(window).on("load", function () {
    $('.preloader').fadeOut();
  })

  // ========================= Header Sticky Js ==============
  $(window).on('scroll', function () {
    if ($(window).scrollTop() >= 300) {
      $('.header').addClass('fixed-header');
    }
    else {
      $('.header').removeClass('fixed-header');
    }
  });

  //============================ Scroll To Top Icon Js =========
  var btn = $('.scroll-top');

  $(window).scroll(function () {
    if ($(window).scrollTop() > 300) {
      btn.addClass('show');
    } else {
      btn.removeClass('show');
    }
  });

  btn.on('click', function (e) {
    e.preventDefault();
    $('html, body').animate({ scrollTop: 0 }, '300');
  });

})(jQuery);
