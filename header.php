<style>
  ::-webkit-scrollbar{
  width: 7px;
  height: 5px;
}
::-webkit-scrollbar-thumb{
  background-color: #725d93;
    border-radius: 4px;
    border: 0;
}
::-webkit-scrollbar-track {
    border-radius: 4px;
}
</style>

<script>
	$(window).on('load', function() { // makes sure the whole site is loaded 
  $('#status').fadeOut(); // will first fade out the loading animation 
  $('#preloader').delay(350).fadeOut('slow'); // will fade out the white DIV that covers the website. 
  $('body').delay(350).css({'overflow':'visible'});
})
	</script>

	
	<nav class="navbar navbar-default  navbar-theme" id="main-nav">
      <div class="container">
        <div class="navbar-inner nav">
          <div class="navbar-header">
            <button class="navbar-toggle collapsed" data-target="#navbar-main" data-toggle="collapse" type="button" area-expanded="false">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.php">
              <img src="img/logo.png" alt="Consta Travel" title="Consta Travel"/>
            </a>
          </div>
          <div class="collapse navbar-collapse" id="navbar-main">
            <ul class="nav navbar-nav">
              <li class="dropdown">
                <a class="dropdown-toggle" href="index.php" >Home</a>
              </li>
			   <li class="dropdown">
                <a class="dropdown-toggle" href="about-us.php" >About</a>
              </li>
             <li class="dropdown">
                <a class="dropdown-toggle" href="#" >Flights</a>
              </li>
			  <li class="dropdown">
                <a class="dropdown-toggle" href="#" >Hotels</a>
               </li>
              <li class="dropdown">
                <a class="dropdown-toggle" href="#" >Bus</a>
               </li>
              
              <li class="dropdown">
                <a class="dropdown-toggle" href="contact.php" >Contact Us</a>
               </li>
             </ul>
            <ul class="nav navbar-nav navbar-right">
              <li class="dropdown">
                <a class="dropdown-toggle" href="#" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                  <span class="_desk-h">Currency</span>
                  <b>USD</b>
                </a>
                <div class="dropdown-menu dropdown-menu-xxl">
                  <h5 class="dropdown-meganav-select-list-title">Popular Currencies</h5>
                  <div class="row" data-gutter="10">
                    <div class="col-md-3">
                      <ul class="dropdown-meganav-select-list-currency">
                        <li>
                          <a href="#">
                            <span>€</span>Euro
                          </a>
                        </li>
                        <li>
                          <a href="#">
                            <span>£</span>Pound sterling
                          </a>
                        </li>
                        <li class="active">
                          <a href="#">
                            <span>US$</span>U.S. dollar
                          </a>
                        </li>
                      </ul>
                    </div>
                    <div class="col-md-3">
                      <ul class="dropdown-meganav-select-list-currency">
                        <li>
                          <a href="#">
                            <span>CAD</span>Canadian dollar
                          </a>
                        </li>
                        <li>
                          <a href="#">
                            <span>AUD</span>Australian dollar
                          </a>
                        </li>
                        <li>
                          <a href="#">
                            <span>RUB</span>Russian Ruble
                          </a>
                        </li>
                      </ul>
                    </div>
                    <div class="col-md-3">
                      <ul class="dropdown-meganav-select-list-currency">
                        <li>
                          <a href="#">
                            <span>S$</span>Singapore dollar
                          </a>
                        </li>
                        <li>
                          <a href="#">
                            <span>CNY</span>Chinese yuan
                          </a>
                        </li>
                        <li>
                          <a href="#">
                            <span>¥</span>Japanese yen
                          </a>
                        </li>
                      </ul>
                    </div>
                  </div>
                  <hr/>
                  <h5 class="dropdown-meganav-select-list-title">All Currencies</h5>
                  <div class="row" data-gutter="10">
                    <div class="col-md-3">
                      <ul class="dropdown-meganav-select-list-currency">
                        <li>
                          <a href="#">
                            <span>AR$</span>Argentine peso
                          </a>
                        </li>
                        <li>
                          <a href="#">
                            <span>AUD</span>Australian dollar
                          </a>
                        </li>
                        <li>
                          <a href="#">
                            <span>AZN</span>Azerbaijan, New Ma...
                          </a>
                        </li>
                        <li>
                          <a href="#">
                            <span>BHD</span>Bahrain dinar
                          </a>
                        </li>
                        <li>
                          <a href="#">
                            <span>BRL</span>Brazilian real
                          </a>
                        </li>
                        <li>
                          <a href="#">
                            <span>BGN</span>Bulgarian lev
                          </a>
                        </li>
                        <li>
                          <a href="#">
                            <span>CAD</span>Canadian dollar
                          </a>
                        </li>
                        <li>
                          <a href="#">
                            <span>XOF</span>CFA Franc BCEAO
                          </a>
                        </li>
                        <li>
                          <a href="#">
                            <span>CL$</span>Chilean peso
                          </a>
                        </li>
                        <li>
                          <a href="#">
                            <span>CNY</span>Chinese yuan
                          </a>
                        </li>
                        <li>
                          <a href="#">
                            <span>COP</span>Colombian peso
                          </a>
                        </li>
                        <li>
                          <a href="#">
                            <span>Kč</span>Czech koruna
                          </a>
                        </li>
                        <li>
                          <a href="#">
                            <span>DKK</span>Danish krone
                          </a>
                        </li>
                      </ul>
                    </div>
                    <div class="col-md-3">
                      <ul class="dropdown-meganav-select-list-currency">
                        <li>
                          <a href="#">
                            <span>EGP</span>Egyptian pound
                          </a>
                        </li>
                        <li>
                          <a href="#">
                            <span>€</span>Euro
                          </a>
                        </li>
                        <li>
                          <a href="#">
                            <span>FJD</span>Fijian dollar
                          </a>
                        </li>
                        <li>
                          <a href="#">
                            <span>GEL</span>Georgian lari
                          </a>
                        </li>
                        <li>
                          <a href="#">
                            <span>HK$</span>Hong Kong Dollar
                          </a>
                        </li>
                        <li>
                          <a href="#">
                            <span>HUF</span>Hungarian forint
                          </a>
                        </li>
                        <li>
                          <a href="#">
                            <span>Rs.</span>Indian rupee
                          </a>
                        </li>
                        <li>
                          <a href="#">
                            <span>Rp</span>Indonesian rupiah
                          </a>
                        </li>
                        <li>
                          <a href="#">
                            <span>₪</span>Israeli new sheqel
                          </a>
                        </li>
                        <li>
                          <a href="#">
                            <span>¥</span>Japanese yen
                          </a>
                        </li>
                        <li>
                          <a href="#">
                            <span>JOD</span>Jordanian dinar
                          </a>
                        </li>
                        <li>
                          <a href="#">
                            <span>KZT</span>Kazakhstani tenge
                          </a>
                        </li>
                        <li>
                          <a href="#">
                            <span>KRW</span>Korean won
                          </a>
                        </li>
                      </ul>
                    </div>
                    <div class="col-md-3">
                      <ul class="dropdown-meganav-select-list-currency">
                        <li>
                          <a href="#">
                            <span>KWD</span>Kuwaiti dinar
                          </a>
                        </li>
                        <li>
                          <a href="#">
                            <span>MYR</span>Malaysian ringgit
                          </a>
                        </li>
                        <li>
                          <a href="#">
                            <span>MXN</span>Mexican peso
                          </a>
                        </li>
                        <li>
                          <a href="#">
                            <span>MDL</span>Moldovan leu
                          </a>
                        </li>
                        <li>
                          <a href="#">
                            <span>NAD</span>Namibian Dollar
                          </a>
                        </li>
                        <li>
                          <a href="#">
                            <span>TWD</span>New Taiwan Dollar
                          </a>
                        </li>
                        <li>
                          <a href="#">
                            <span>NZD</span>New Zealand dollar
                          </a>
                        </li>
                        <li>
                          <a href="#">
                            <span>NOK</span>Norwegian krone
                          </a>
                        </li>
                        <li>
                          <a href="#">
                            <span>OMR</span>Omani rial
                          </a>
                        </li>
                        <li>
                          <a href="#">
                            <span>zł</span>Polish zloty
                          </a>
                        </li>
                        <li>
                          <a href="#">
                            <span>£</span>Pound sterling
                          </a>
                        </li>
                        <li>
                          <a href="#">
                            <span>QAR</span>Qatar riyal
                          </a>
                        </li>
                        <li>
                          <a href="#">
                            <span>lei</span>Romanian new leu
                          </a>
                        </li>
                      </ul>
                    </div>
                    <div class="col-md-3">
                      <ul class="dropdown-meganav-select-list-currency">
                        <li>
                          <a href="#">
                            <span>RUB</span>Russian Ruble
                          </a>
                        </li>
                        <li>
                          <a href="#">
                            <span>SAR</span>Saudi Arabian riyal
                          </a>
                        </li>
                        <li>
                          <a href="#">
                            <span>S$</span>Singapore dollar
                          </a>
                        </li>
                        <li>
                          <a href="#">
                            <span>ZAR</span>South African rand
                          </a>
                        </li>
                        <li>
                          <a href="#">
                            <span>SEK</span>Swedish krona
                          </a>
                        </li>
                        <li>
                          <a href="#">
                            <span>CHF</span>Swiss franc
                          </a>
                        </li>
                        <li>
                          <a href="#">
                            <span>THB</span>Thai baht
                          </a>
                        </li>
                        <li>
                          <a href="#">
                            <span>TL</span>Turkish lira
                          </a>
                        </li>
                        <li>
                          <a href="#">
                            <span>AED</span>U.A.E. dirham
                          </a>
                        </li>
                        <li class="active">
                          <a href="#">
                            <span>US$</span>U.S. dollar
                          </a>
                        </li>
                        <li>
                          <a href="#">
                            <span>UAH</span>Ukraine Hryvnia
                          </a>
                        </li>
                        <li>
                          <a href="#">
                            <span>UZS</span>Uzbekistan, Sums
                          </a>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
              </li>
              <li class="dropdown">
                <a class="dropdown-toggle" href="#" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                  <span class="_desk-h">Language</span>
                  <img class="navbar-flag" src="img/flags/USA.png" alt="Image Alternative text" title="Image Title"/>
                </a>
                <div class="dropdown-menu dropdown-menu-xxl">
                  <h5 class="dropdown-meganav-select-list-title">Languages</h5>
                  <div class="row" data-gutter="10">
                    <div class="col-md-3">
                      <ul class="dropdown-meganav-select-list-lang">
                        <li>
                          <a href="#">
                            <img src="img/flag_codes/UK.png" alt="Image Alternative text" title="Image Title"/>English(UK)
                          </a>
                        </li>
                        <li class="active">
                          <a href="#">
                            <img src="img/flag_codes/US.png" alt="Image Alternative text" title="Image Title"/>English(US)
                          </a>
                        </li>
                        <li>
                          <a href="#">
                            <img src="img/flag_codes/DE.png" alt="Image Alternative text" title="Image Title"/>Deutsch
                          </a>
                        </li>
                        <li>
                          <a href="#">
                            <img src="img/flag_codes/NED.png" alt="Image Alternative text" title="Image Title"/>Nederlands
                          </a>
                        </li>
                        <li>
                          <a href="#">
                            <img src="img/flag_codes/FR.png" alt="Image Alternative text" title="Image Title"/>Français
                          </a>
                        </li>
                        <li>
                          <a href="#">
                            <img src="img/flag_codes/SP.png" alt="Image Alternative text" title="Image Title"/>Español
                          </a>
                        </li>
                        <li>
                          <a href="#">
                            <img src="img/flag_codes/ARG.png" alt="Image Alternative text" title="Image Title"/>Español (AR)
                          </a>
                        </li>
                        <li>
                          <a href="#">
                            <img src="img/flag_codes/IT.png" alt="Image Alternative text" title="Image Title"/>Italiano
                          </a>
                        </li>
                        <li>
                          <a href="#">
                            <img src="img/flag_codes/PT.png" alt="Image Alternative text" title="Image Title"/>Português (PT)
                          </a>
                        </li>
                        <li>
                          <a href="#">
                            <img src="img/flag_codes/BR.png" alt="Image Alternative text" title="Image Title"/>Português (BR)
                          </a>
                        </li>
                        <li>
                          <a href="#">
                            <img src="img/flag_codes/NR.png" alt="Image Alternative text" title="Image Title"/>Norsk
                          </a>
                        </li>
                      </ul>
                    </div>
                    <div class="col-md-3">
                      <ul class="dropdown-meganav-select-list-lang">
                        <li>
                          <a href="#">
                            <img src="img/flag_codes/FIN.png" alt="Image Alternative text" title="Image Title"/>Suomi
                          </a>
                        </li>
                        <li>
                          <a href="#">
                            <img src="img/flag_codes/SW.png" alt="Image Alternative text" title="Image Title"/>Svenska
                          </a>
                        </li>
                        <li>
                          <a href="#">
                            <img src="img/flag_codes/DEN.png" alt="Image Alternative text" title="Image Title"/>Dansk
                          </a>
                        </li>
                        <li>
                          <a href="#">
                            <img src="img/flag_codes/CZ.png" alt="Image Alternative text" title="Image Title"/>Čeština
                          </a>
                        </li>
                        <li>
                          <a href="#">
                            <img src="img/flag_codes/HUN.png" alt="Image Alternative text" title="Image Title"/>Magyar
                          </a>
                        </li>
                        <li>
                          <a href="#">
                            <img src="img/flag_codes/ROM.png" alt="Image Alternative text" title="Image Title"/>Română
                          </a>
                        </li>
                        <li>
                          <a href="#">
                            <img src="img/flag_codes/JP.png" alt="Image Alternative text" title="Image Title"/>日本語
                          </a>
                        </li>
                        <li>
                          <a href="#">
                            <img src="img/flag_codes/CN.png" alt="Image Alternative text" title="Image Title"/>简体中文
                          </a>
                        </li>
                        <li>
                          <a href="#">
                            <img src="img/flag_codes/PL.png" alt="Image Alternative text" title="Image Title"/>Polski
                          </a>
                        </li>
                        <li>
                          <a href="#">
                            <img src="img/flag_codes/GR.png" alt="Image Alternative text" title="Image Title"/>Ελληνικά
                          </a>
                        </li>
                        <li>
                          <a href="#">
                            <img src="img/flag_codes/RU.png" alt="Image Alternative text" title="Image Title"/>Русский
                          </a>
                        </li>
                      </ul>
                    </div>
                    <div class="col-md-3">
                      <ul class="dropdown-meganav-select-list-lang">
                        <li>
                          <a href="#">
                            <img src="img/flag_codes/TUR.png" alt="Image Alternative text" title="Image Title"/>Türkçe
                          </a>
                        </li>
                        <li>
                          <a href="#">
                            <img src="img/flag_codes/BUL.png" alt="Image Alternative text" title="Image Title"/>Български
                          </a>
                        </li>
                        <li>
                          <a href="#">
                            <img src="img/flag_codes/ARB.png" alt="Image Alternative text" title="Image Title"/>العربية
                          </a>
                        </li>
                        <li>
                          <a href="#">
                            <img src="img/flag_codes/KOR.png" alt="Image Alternative text" title="Image Title"/>한국어
                          </a>
                        </li>
                        <li>
                          <a href="#">
                            <img src="img/flag_codes/ISR.png" alt="Image Alternative text" title="Image Title"/>עברית
                          </a>
                        </li>
                        <li>
                          <a href="#">
                            <img src="img/flag_codes/LAT.png" alt="Image Alternative text" title="Image Title"/>Latviski
                          </a>
                        </li>
                        <li>
                          <a href="#">
                            <img src="img/flag_codes/UKR.png" alt="Image Alternative text" title="Image Title"/>Українська
                          </a>
                        </li>
                        <li>
                          <a href="#">
                            <img src="img/flag_codes/IND.png" alt="Image Alternative text" title="Image Title"/>Bahasa Indonesia
                          </a>
                        </li>
                        <li>
                          <a href="#">
                            <img src="img/flag_codes/MAL.png" alt="Image Alternative text" title="Image Title"/>Bahasa Malaysia
                          </a>
                        </li>
                        <li>
                          <a href="#">
                            <img src="img/flag_codes/TAI.png" alt="Image Alternative text" title="Image Title"/>ภาษาไทย
                          </a>
                        </li>
                        <li>
                          <a href="#">
                            <img src="img/flag_codes/EST.png" alt="Image Alternative text" title="Image Title"/>Eesti
                          </a>
                        </li>
                      </ul>
                    </div>
                    <div class="col-md-3">
                      <ul class="dropdown-meganav-select-list-lang">
                        <li>
                          <a href="#">
                            <img src="img/flag_codes/CRO.png" alt="Image Alternative text" title="Image Title"/>Hrvatski
                          </a>
                        </li>
                        <li>
                          <a href="#">
                            <img src="img/flag_codes/LIT.png" alt="Image Alternative text" title="Image Title"/>Lietuvių
                          </a>
                        </li>
                        <li>
                          <a href="#">
                            <img src="img/flag_codes/SLO.png" alt="Image Alternative text" title="Image Title"/>Slovenčina
                          </a>
                        </li>
                        <li>
                          <a href="#">
                            <img src="img/flag_codes/SERB.png" alt="Image Alternative text" title="Image Title"/>Srpski
                          </a>
                        </li>
                        <li>
                          <a href="#">
                            <img src="img/flag_codes/SLOVE.png" alt="Image Alternative text" title="Image Title"/>Slovenščina
                          </a>
                        </li>
                        <li>
                          <a href="#">
                            <img src="img/flag_codes/NAM.png" alt="Image Alternative text" title="Image Title"/>Tiếng Việt
                          </a>
                        </li>
                        <li>
                          <a href="#">
                            <img src="img/flag_codes/PHI.png" alt="Image Alternative text" title="Image Title"/>Filipino
                          </a>
                        </li>
                        <li>
                          <a href="#">
                            <img src="img/flag_codes/ICE.png" alt="Image Alternative text" title="Image Title"/>Íslenska
                          </a>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
              </li>
              <li class="active navbar-nav-item-user dropdown">
               
				<?php 
				if(empty($login)){
				?>
				 <a class="dropdown-toggle" href="account.php" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                  <i class="fa fa-user-circle-o navbar-nav-item-user-icon"></i>My Account
                </a>
				<ul class="dropdown-menu">
				<li>
				<a href="register.php">Register</a>
				</li>
				<li>
				<a href="login.php">Login</a>
				</li>
				
				
				</ul>
				<?php
				}
				else{
					
				$loginnamequery = 	mysql_query("SELECT * FROM `users` WHERE id=".$login." ");
				$loginnamerow = mysql_fetch_array($loginnamequery);
				
				?>
				 <a class="dropdown-toggle" href="account.php" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                  <i class="fa fa-user-circle-o navbar-nav-item-user-icon"></i><?php echo $loginnamerow[1]." ".$loginnamerow[2] ; ?>
                </a>
				<ul class="dropdown-menu">
				<li>
				<a href="profile.php">Profile</a>
				</li>
				<li>
				<a href="add_travelers.php">My Travellers</a>
				</li>
				<li>
				<a href="mytrips.php">My Trips</a>
				</li>
				
				<li>
				<a href="logout.php">Log Out</a>
				</li>
				</ul>
                <?php
				}
				?>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </nav>
   