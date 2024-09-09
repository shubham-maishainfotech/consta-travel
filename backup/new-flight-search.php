<!DOCTYPE HTML>
<html lang="en">

<head>
  <title>Consta Travel - Flight results </title>
  <link rel="stylesheet" href="./css/new-styles.css">

  <?php
  include('head.php');
  ?>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick-theme.css" />
</head>

<body style="overflow-x: hidden !important;">
  <?php
  include('header.php');
  ?>

  <section class="main_flight__results">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <div class="top_search__form">
            <form action="">
              <div class="re_form__control">
                <select class="form-select" aria-label="Default select example">
                  <option value="1">One way</option>
                  <option value="2">Round Trip</option>
                </select>
              </div>
              <div class="re_form__control">
                <div class="hny_switch">
                  <input type="text" id="input1" class="input-field" placeholder="Departure">
                  <button type="button" id="toggleButton">
                    <svg width="24px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#735C93">
                      <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                      <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                      <g id="SVGRepo_iconCarrier">
                        <path d="M21 9L9 9" stroke="#735C93" stroke-width="0.8879999999999999" stroke-linecap="round" stroke-linejoin="round"></path>
                        <path d="M15 15L3 15" stroke="#735C93" stroke-width="0.8879999999999999" stroke-linecap="round" stroke-linejoin="round"></path>
                        <path d="M18 12L20.913 9.08704V9.08704C20.961 9.03897 20.961 8.96103 20.913 8.91296V8.91296L18 6" stroke="#735C93" stroke-width="0.8879999999999999" stroke-linecap="round" stroke-linejoin="round"></path>
                        <path d="M6 18L3.08704 15.087V15.087C3.03897 15.039 3.03897 14.961 3.08704 14.913V14.913L6 12" stroke="#735C93" stroke-width="0.8879999999999999" stroke-linecap="round" stroke-linejoin="round"></path>
                      </g>
                    </svg>
                  </button>
                  <input type="text" id="input2" class="input-field" placeholder="Arrival">
                </div>
              </div>
              <div class="re_form__control">
                <input type="date" class="input-field">
              </div>
              <div class="re_form__control">
                <input type="date" class="input-field" placeholder="Return">
              </div>
              <div class="re_form__control">
                <h3>1 Traveller <i class="fa fa-angle-up"></i></h3>
                <div class="travler_list">
                  <h5>Travellers</h5>
                  <div class="add_trav__more">
                    <ul>
                      <li>
                        <h4>Adults</h4>
                        <div class="quantity-field">
                          <button class="value-button decrease-button" onclick="decreaseValue(this)" title="Azalt">-</button>
                          <div class="number">0</div>
                          <button class="value-button increase-button" onclick="increaseValue(this, 5)" title="Arrtır">+
                          </button>
                        </div>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
              <div class="re_form__control">
                <button type="button" id="main_re__search">Search</button>
              </div>
            </form>
          </div>
        </div>

        <div class="col-12">
          <div class="row">
            <div class="col-lg-3">
              <div class="aside_left__section">
                <p><strong>86 of 86</strong> Flights</p>

                <div class="flight_upgrade">
                  <p>Get discounted seats and meals with Cleartrip Upgrade</p>

                  <div class="shop_flight">
                    <p>Show flights with Upgrade</p>
                    <label class="switch">
                      <input type="checkbox">
                      <span class="slider"></span>
                    </label>
                  </div>
                </div>
                <div class="accordion-container">
                  <div class="set">
                    <a href="javascript:;"> Stops <i class="fa fa-angle-up"></i> </a>
                    <div class="content">
                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1" checked>
                        <label class="form-check-label" for="flexRadioDefault1">
                          Non-Stop
                        </label>
                      </div>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2">
                        <label class="form-check-label" for="flexRadioDefault2">
                          1 Stop
                        </label>
                      </div>
                    </div>
                  </div>
                  <div class="set">
                    <a href="javascript:;"> Departure time<i class="fa fa-angle-up"></i> </a>

                    <div class="content">
                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1" checked>
                        <label class="form-check-label hny" for="flexRadioDefault1">
                          Early morning <span>Midnight-8pm</span>
                        </label>
                      </div>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2">
                        <label class="form-check-label hny" for="flexRadioDefault2">
                          Morning <span>8am - Noon</span>
                        </label>
                      </div>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2">
                        <label class="form-check-label hny" for="flexRadioDefault2">
                          Afternoon <span>8am - Noon</span>
                        </label>
                      </div>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2">
                        <label class="form-check-label hny" for="flexRadioDefault2">
                          Evening <span>8am - Noon</span>
                        </label>
                      </div>
                    </div>

                  </div>
                  <div class="set">
                    <a href="javascript:;"> One-way price <i class="fa fa-angle-up"></i> </a>
                    <div class="content">
                      <p>Pellentesque aliquam ligula libero, vitae imperdiet diam porta vitae. sed do eiusmod tempor incididunt ut labore et dolore magna.</p>
                    </div>
                  </div>
                  <div class="set">
                    <a href="javascript:;"> Airlines <i class="fa fa-angle-up"></i></a>
                    <div class="content">
                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1" checked>
                        <label class="form-check-label hny" for="flexRadioDefault1">
                          Early morning <span>Midnight-8pm</span>
                        </label>
                      </div>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2">
                        <label class="form-check-label hny" for="flexRadioDefault2">
                          Morning <span>8am - Noon</span>
                        </label>
                      </div>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2">
                        <label class="form-check-label hny" for="flexRadioDefault2">
                          Afternoon <span>8am - Noon</span>
                        </label>
                      </div>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2">
                        <label class="form-check-label hny" for="flexRadioDefault2">
                          Evening <span>8am - Noon</span>
                        </label>
                      </div>
                    </div>
                  </div>
                </div>

              </div>
            </div>
            <div class="col-lg-9">
              <div class="right_top__offerslider">
                <div class="slider responsive">
                  <div>
                    <div class="offer_card__hny">
                      <img src="img/ct_offer.png" alt="">
                      <div>
                        <h3>Up to 20% off + No Cost EMI</h3>
                        <p><strong>TRAVELMAX</strong> Applicable on all payments modes</p>
                      </div>
                    </div>
                  </div>

                  <div>
                    <div class="offer_card__hny">
                      <img src="img/sbi.svg" alt="">
                      <div>
                        <h3>Up to 25% off + No Cost EMI</h3>
                        <p><strong>SBIMAX</strong> with SBI Credit Cards</p>
                      </div>
                    </div>
                  </div>

                  <div>
                    <div class="offer_card__hny">
                      <img src="img/ct_offer.png" alt="">
                      <div>
                        <h3>Up to 20% off + No Cost EMI</h3>
                        <p><strong>TRAVELMAX</strong> Applicable on all payments modes</p>
                      </div>
                    </div>
                  </div>
                  <div>
                    <div class="offer_card__hny">
                      <img src="img/sbi.svg" alt="">
                      <div>
                        <h3>Up to 25% off + No Cost EMI</h3>
                        <p><strong>SBIMAX</strong> with SBI Credit Cards</p>
                      </div>
                    </div>
                  </div>
                  <div>
                    <div class="offer_card__hny">
                      <img src="img/ct_offer.png" alt="">
                      <div>
                        <h3>Up to 20% off + No Cost EMI</h3>
                        <p><strong>TRAVELMAX</strong> Applicable on all payments modes</p>
                      </div>
                    </div>
                  </div>

                </div>
              </div>

              <div id="material-tabs">
                <div class="teb_slider__area">
                  <div><a id="tab1-tab" href="#tab1" class="active_hny">Wed, 24 jul <span>&#8377;3,400</span></a></div>
                  <div><a id="tab2-tab" href="#tab2">Thu, 25 jul <span>&#8377;3,400</a></div>
                  <div><a id="tab3-tab" href="#tab3">Fri, 26 jul <span>&#8377;3,400</a></div>
                  <div><a id="tab4-tab" href="#tab4">Set, 27 jul <span>&#8377;3,400</a></div>
                  <div><a id="tab4-tab" href="#tab5">Set, 27 jul <span>&#8377;3,400</a></div>
                  <div><a id="tab4-tab" href="#tab6">Set, 27 jul <span>&#8377;3,400</a></div>
                  <div><a id="tab4-tab" href="#tab7">Set, 27 jul <span>&#8377;3,400</a></div>
                  <div><a id="tab4-tab" href="#tab8">Set, 27 jul <span>&#8377;3,400</a></div>
                </div>
                <span class="yellow-bar"></span>
              </div>
              <div class="theme-search-results" id="tobePagination">

                <div class="theme-search-results-item _mb-10 theme-search-results-item-rounded theme-search-results-item-">
                  <div class="theme-search-results-item-preview">
                    <div class="row main_container" data-gutter="20">
                      <div class="col-md-8 ">
                        <div class="theme-search-results-item-flight-sections">
                          <div class="theme-search-results-item-flight-section">
                            <div class="row row-no-gutter row-eq-height">
                              <div class="col-md-2 ">
                                <div class="theme-search-results-item-flight-section-airline-logo-wrap">
                                  <img class="theme-search-results-item-flight-section-airline-logo" src="img/flight.png" alt="Consta Travel" title="Image Title" />
                                </div>
                              </div>
                              <div class="col-md-10 ">
                                <div class="theme-search-results-item-flight-section-item">
                                  <div class="row">
                                    <div class="col-md-3">
                                      <div class="theme-search-results-item-flight-section-meta">
                                        <p class="theme-search-results-item-flight-section-meta-time">
                                          10:10
                                        </p>
                                        <p class="theme-search-results-item-flight-section-meta-city">
                                          New Delhi
                                        </p>
                                        <p class="theme-search-results-item-flight-section-meta-date">
                                          26 July, Friday
                                        </p>
                                      </div>
                                    </div>
                                    <div class="col-md-4 ">
                                      <div class="theme-search-results-item-flight-section-path">
                                        <div class="theme-search-results-item-flight-section-path-fly-time">
                                          <p>3H 30MIN</p>
                                        </div>
                                        <div class="theme-search-results-item-flight-section-path-line"></div>

                                        <div class="theme-search-results-item-flight-section-path-status">
                                          <h5 class="theme-search-results-item-flight-section-airline-title">( Non Stop )</h5>
                                        </div>

                                        <div class="theme-search-results-item-flight-section-path-line-start">
                                          <i class="fa fa-plane theme-search-results-item-flight-section-path-icon"></i>
                                          <div class="theme-search-results-item-flight-section-path-line-dot"></div>
                                          <div class="theme-search-results-item-flight-section-path-line-title">DEL</div>
                                        </div>

                                        <div class="theme-search-results-item-flight-section-path-line-end">
                                          <i class="fa fa-plane theme-search-results-item-flight-section-path-icon"></i>
                                          <div class="theme-search-results-item-flight-section-path-line-dot"></div>
                                          <div class="theme-search-results-item-flight-section-path-line-title">DXB</div>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="col-md-3 ">
                                      <div class="theme-search-results-item-flight-section-meta">

                                        <p class="theme-search-results-item-flight-section-meta-time">
                                          12:10
                                        </p>
                                        <p class="theme-search-results-item-flight-section-meta-city">Dubai</p>
                                        <p class="theme-search-results-item-flight-section-meta-date">26 July, Friday</p>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <a href="#searchResultsItem" role="button" data-toggle="collapse" aria-expanded="true" aria-controls="searchResultsItem" id="accordian_btn">
                              <h5 class="theme-search-results-item-flight-section-airline-title">View Flight Details</h5>
                            </a>

                          </div>
                        </div>
                      </div>
                      <div class="col-md-4 ">
                        <div class="theme-search-results-item-book">
                          <div class="theme-search-results-item-price">
                            <p class="theme-search-results-item-price-tag"><i class="fa fa-eur" aria-hidden="true"></i>138.54</p>
                            <p class="theme-search-results-item-price-sign">Economy</p>
                          </div>
                          <a class="btn btn-primary-inverse btn-block theme-search-results-item-price-btn" target="_blank" href="flight-payment.php?token">Book Now</a>

                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="collapse theme-search-results-item-collapse" id="searchResultsItem">
                    <div class="theme-search-results-item-extend">
                      <a class="theme-search-results-item-extend-close" href="#searchResultsItem" role="button" data-toggle="collapse" aria-expanded="true" aria-controls="searchResultsItem" id="accordian_close">&#10005;</a>
                      <div class="theme-search-results-item-extend-inner">
                        <div class="theme-search-results-item-flight-detail-items">
                          <div class="theme-search-results-item-flight-details">
                            <div class="row">
                              <div class="col-md-3 ">
                                <div class="theme-search-results-item-flight-details-info">
                                  <h5 class="theme-search-results-item-flight-details-info-title">Depart</h5>
                                  <p class="theme-search-results-item-flight-details-info-date">Saturday , July 26</p>
                                  <p class="theme-search-results-item-flight-details-info-cities">New Delhi → Dubai</p>
                                  <p class="theme-search-results-item-flight-details-info-fly-time">14H20M</p>
                                  <p class="theme-search-results-item-flight-details-info-stops">Stops : 1</p>
                                </div>
                              </div>
                              <div class="col-md-9 ">
                                <div class="theme-search-results-item-flight-details-schedule">
                                  <ul class="theme-search-results-item-flight-details-schedule-list">
                                    <li>
                                      <i class="fa fa-plane theme-search-results-item-flight-details-schedule-icon"></i>
                                      <div class="theme-search-results-item-flight-details-schedule-dots"></div>
                                      <p class="theme-search-results-item-flight-details-schedule-date">Saturday , July 20  </p>
                                      <div class="theme-search-results-item-flight-details-schedule-time">
                                        <span class="theme-search-results-item-flight-details-schedule-time-item">10:30 - 17:00
                                        </span>
                                        <span class="theme-search-results-item-flight-details-schedule-time-separator">&mdash;</span>

                                      </div>
                                      <p class="theme-search-results-item-flight-details-schedule-fly-time">8H30M</p>
                                      <div class="theme-search-results-item-flight-details-schedule-destination">
                                        <div class="theme-search-results-item-flight-details-schedule-destination-item">
                                          <p class="theme-search-results-item-flight-details-schedule-destination-title">
                                            <b>SYD</b>
                                          </p>
                                          <p class="theme-search-results-item-flight-details-schedule-destination-city">Sydney</p>
                                        </div>
                                        <div class="theme-search-results-item-flight-details-schedule-destination-separator">
                                          <span>&rarr;</span>
                                        </div>
                                        <div class="theme-search-results-item-flight-details-schedule-destination-item">
                                          <p class="theme-search-results-item-flight-details-schedule-destination-title">
                                            <b>MNL</b>
                                          </p>

                                          <p class="theme-search-results-item-flight-details-schedule-destination-city">Manila</p>
                                        </div>
                                      </div>

                                    </li>
                                  </ul>
                                </div>



                                <div class="theme-search-results-item-flight-details-schedule">
                                  <ul class="theme-search-results-item-flight-details-schedule-list">
                                    <li>
                                      <i class="fa fa-clock-o theme-search-results-item-flight-details-schedule-icon"></i>
                                      <div class="theme-search-results-item-flight-details-schedule-dots"></div>
                                      <p class="theme-search-results-item-flight-details-schedule-date"> &nbsp; </p>
                                      <div class="theme-search-results-item-flight-details-schedule-time">
                                        <span class="theme-search-results-item-flight-details-schedule-time-item">  MNL ( Layover )
                                        </span>

                                        <span class="theme-search-results-item-flight-details-schedule-time-separator">&mdash;</span>

                                      </div>



                                      <p class="theme-search-results-item-flight-details-schedule-fly-time">-2h:-35m</p>
                                      <div class="theme-search-results-item-flight-details-schedule-destination">
                                        <div class="theme-search-results-item-flight-details-schedule-destination-item">
                                          <p class="theme-search-results-item-flight-details-schedule-destination-title">
                                            <b></b>
                                          </p>

                                          <p class="theme-search-results-item-flight-details-schedule-destination-city"></p>
                                        </div>
                                        <div class="theme-search-results-item-flight-details-schedule-destination-separator">
                                          <span></span>
                                        </div>
                                        <div class="theme-search-results-item-flight-details-schedule-destination-item">
                                          <p class="theme-search-results-item-flight-details-schedule-destination-title">
                                            <b></b>
                                          </p>

                                          <p class="theme-search-results-item-flight-details-schedule-destination-city"></p>
                                        </div>
                                      </div>

                                    </li>
                                  </ul>
                                </div>





                                <div class="theme-search-results-item-flight-details-schedule">
                                  <ul class="theme-search-results-item-flight-details-schedule-list">
                                    <li>
                                      <i class="fa fa-exchange theme-search-results-item-flight-details-schedule-icon"></i>
                                      <div class="theme-search-results-item-flight-details-schedule-dots"></div>
                                      <p class="theme-search-results-item-flight-details-schedule-date">Saturday , July 20  </p>
                                      <div class="theme-search-results-item-flight-details-schedule-time">
                                        <span class="theme-search-results-item-flight-details-schedule-time-item">
                                        19:15 - 21:50
                                        </span>
                                        <span class="theme-search-results-item-flight-details-schedule-time-separator">&mdash;</span>

                                      </div>
                                      <p class="theme-search-results-item-flight-details-schedule-fly-time">3H35M</p>
                                      <div class="theme-search-results-item-flight-details-schedule-destination">
                                        <div class="theme-search-results-item-flight-details-schedule-destination-item">
                                          <p class="theme-search-results-item-flight-details-schedule-destination-title">
                                            <b>MNL</b>
                                          </p>

                                          <p class="theme-search-results-item-flight-details-schedule-destination-city">Manila</p>
                                        </div>
                                        <div class="theme-search-results-item-flight-details-schedule-destination-separator">
                                          <span>&rarr;</span>
                                        </div>
                                        <div class="theme-search-results-item-flight-details-schedule-destination-item">
                                          <p class="theme-search-results-item-flight-details-schedule-destination-title">
                                            <b>BKK</b>
                                          </p>

                                          <p class="theme-search-results-item-flight-details-schedule-destination-city">Bangkok</p>
                                        </div>
                                      </div>

                                    </li>
                                  </ul>
                                </div>

                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                </div>

              </div>

            </div>

          </div>
        </div>
      </div>
    </div>
    </div>
  </section>
  <!-- offcanvas -->
  <div class="overlay"></div>
  <div class="offcanvas__hny">
    <div class="offcanvas-header">
      <h5 class="offcanvas-title" id="offcanvasRightLabel">Offcanvas right</h5>
      <button class="btn-close-hny"><i class="fa fa-close"></i></button>
    </div>
    <div class="offcanvas-body">
      ...
    </div>
  </div>
  <?php include('footer.php'); ?>


  <script type="text/javascript" src="//code.jquery.com/jquery-1.11.0.min.js"></script>
  <script type="text/javascript" src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.js"></script>
  <script>
    $(document).ready(function() {
      $('#tobePagination').buzinaPagination({
        itemsOnPage: 10
      });
    });
  </script>
  <script>
    $(document).ready(function() {
      $('#material-tabs').each(function() {

        var $active, $content, $links = $(this).find('a');

        $active = $($links[0]);
        $active.addClass('active_hny');

        $content = $($active[0].hash);

        $links.not($active).each(function() {
          $(this.hash).hide();
        });

        $(this).on('click', 'a', function(e) {

          $active.removeClass('active_hny');
          $content.hide();

          $active = $(this);
          $content = $(this.hash);

          $active.addClass('active_hny');
          $content.show();

          e.preventDefault();
        });
      });
    });
  </script>
  <script>
    $('.offer_card__hny').click(function() {
      $('.offcanvas__hny').animate({
        right: "0%"
      }, 200);
      $('.overlay').addClass('hddd');
      $('body').addClass('hddd_over');
    });
    $('.btn-close-hny').click(function() {
      $('.offcanvas__hny').animate({
        right: "-100%"
      }, 200);
      $('.overlay').removeClass('hddd');
      $('body').removeClass('hddd_over');

    });
    $('.overlay').click(function() {
      $('.offcanvas__hny').animate({
        right: "-100%"
      }, 200);
      $('.overlay').removeClass('hddd');
      $('body').removeClass('hddd_over');

    });
  </script>
  <script>
    $('.responsive').slick({
      dots: false,
      infinite: false,
      speed: 300,
      slidesToShow: 3,
      prevArrow: '<button type="button" class="slick-prev"><i class="fa fa-arrow-left"></i></button>',
      nextArrow: '<button type="button" class="slick-next"><i class="fa fa-arrow-right"></i></button>',
      slidesToScroll: 1,
      draggable: false,
      swipeToSlide: false,
      touchMove: false,
      responsive: [{
          breakpoint: 1024,
          settings: {
            slidesToShow: 3,
            slidesToScroll: 3,
            infinite: true,
            dots: true
          }
        },
        {
          breakpoint: 600,
          settings: {
            slidesToShow: 2,
            slidesToScroll: 2
          }
        },
        {
          breakpoint: 480,
          settings: {
            slidesToShow: 1,
            slidesToScroll: 1
          }
        }
        // You can unslick at a given breakpoint now by adding:
        // settings: "unslick"
        // instead of a settings object
      ]
    });
  </script>
  <script>
    $('.teb_slider__area').slick({
      dots: false,
      infinite: false,
      speed: 300,
      slidesToShow: 7,
      slidesToScroll: 1,
      draggable: false,
      swipeToSlide: false,
      touchMove: false,
      responsive: [{
          breakpoint: 1024,
          settings: {
            slidesToShow: 3,
            slidesToScroll: 3,
            infinite: true,
            dots: true
          }
        },
        {
          breakpoint: 600,
          settings: {
            slidesToShow: 2,
            slidesToScroll: 2
          }
        },
        {
          breakpoint: 480,
          settings: {
            slidesToShow: 1,
            slidesToScroll: 1
          }
        }
        // You can unslick at a given breakpoint now by adding:
        // settings: "unslick"
        // instead of a settings object
      ]
    });
  </script>
  <script>
    $(".travler_list").hide()
    $(".re_form__control h3").click(function() {
      $(".travler_list").toggle(200)
      $('.re_form__control i').addClass("hny_rota")
    })
  </script>

  <script>
    function increaseValue(button, limit) {
      const numberInput = button.parentElement.querySelector('.number');
      var value = parseInt(numberInput.innerHTML, 10);
      if (isNaN(value)) value = 0;
      if (limit && value >= limit) return;
      numberInput.innerHTML = value + 1;
    }


    function decreaseValue(button) {
      const numberInput = button.parentElement.querySelector('.number');
      var value = parseInt(numberInput.innerHTML, 10);
      if (isNaN(value)) value = 0;
      if (value < 1) return;
      numberInput.innerHTML = value - 1;
    }
  </script>
  <script>

  </script>

  <script>
    $(window).on('load', function() { // makes sure the whole site is loaded 
      //alert('loaded');
      document.getElementById("preloader").style.display = "none";
    })
  </script>
  <script src="./js/custom-javascript.js"></script>

  <!-- Script for accordian  -->
   <script>
      let accordianBtn = document.getElementById("accordian_btn")
      accordianBtn.addEventListener('click', function(event) {
        event.preventDefault();
        let collapseDiv = document.getElementById("searchResultsItem");
        if (collapseDiv.style.display === 'none') {
                collapseDiv.style.display = 'block';
            } else {
                collapseDiv.style.display = 'none';
            }
      })
   </script>

<script>
      let accordianClose = document.getElementById("accordian_close")
      accordianClose.addEventListener('click', function(event) {
        event.preventDefault();
        let collapseDiv = document.getElementById("searchResultsItem");
        if (collapseDiv.style.display === 'block') {
                collapseDiv.style.display = 'none';
            } else {
                collapseDiv.style.display = 'block';
            }
      })
   </script>
</body>

</html>