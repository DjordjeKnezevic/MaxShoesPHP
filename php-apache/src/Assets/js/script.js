var tmpGreska = false;
const BASEURL = "Assets/data/";
window.onload = async function () {
  //* * * * * * * * * * * * * * * * * * * * * ZAJEDNICKI DEO ZA SVE STRANICE * * * * * * * * * * * * * * * * * * * * * * * *//
  if (window.innerWidth < 650) {
    let logoIme = document.getElementById("logo-ime");
    logoIme.textContent = "MS";
    logoIme.classList.remove("text-light");
    logoIme.classList.add("lgreen-lg");
  }

  // ANIMACIJA NAVBARA PRI SCROLL-U (POJAVLJIVANJE I NESTAJANJE)
  let lastScroll = 0;
  navbar = document.querySelector(".navbar-meni");
  const validateHeader = () => {
    const windowY = window.scrollY;
    const windowH = window.innerHeight;
    if (windowY > windowH - 1400) {
      navbar.classList.add("is-fixed");
    } else {
      navbar.classList.remove("is-fixed");
    }
    if (windowY < lastScroll) {
      navbar.classList.add("scroll-up");
    } else {
      navbar.classList.remove("scroll-up");
    }
    lastScroll = windowY;
  };
  window.addEventListener("scroll", validateHeader);

  $("#profile-ddtoggle").click(function () {
    $(this).next().slideToggle("fast");
  });

  let logoutDugme = document.querySelector("#logout");
  if (logoutDugme) {
    logoutDugme.addEventListener("click", async function () {
      await ajaxCall("logout.php", "post");
      window.location.href = "/index.php";
    });
  }

  // LOGOVANJE KORISNIKA
  let logovanjeForma = document.querySelector("#logovanje-forma");
  let uspesnoLogovanje = document.querySelector(
    "#logovanje-forma .alert-success"
  );
  let usernameEmailLoginPolje = document.querySelector("#login-user-email");
  let passwordLoginPolje = document.querySelector("#log-pass");
  let loginDugme = document.getElementById("loginSubmit");
  logovanjeForma.addEventListener("submit", async (event) => {
    event.preventDefault();
    let loginUsernameEmail = usernameEmailLoginPolje.value;
    let loginPassword = passwordLoginPolje.value;
    let trazeniKorisnik = {
      loginUsernameEmail,
      loginPassword,
    };
    loginDugme.disabled = true;
    document.getElementById("loginProcess").classList.remove("hide");
    let res = await ajaxCall("login.php", "post", {
      trazeniKorisnik,
    });
    document.getElementById("loginProcess").classList.add("hide");
    uspesnoLogovanje.classList.remove("hide");
    setTimeout(() => {
      window.location.href = "/index.php?page=products";
    }, 1000);
  });

  let signupForma = document.querySelector("#signup-forma");
  signupForma.addEventListener("submit", (event) => {
    event.preventDefault();
  });

  // PROVERA ISPRAVNOSTI USERNAME-A
  const reUsername = [
    /^[\w\d!@#\$%\^&\*\._]{5,20}$/,
    /^[A-Z][\w\d!@#\$%\^&\*\._]{4,19}$/,
  ];
  const porukaUsername = [
    "Username must be between 5 and 20 characters long and must not contain spaces",
    "Username must start with a capital letter",
  ];

  let signupUsername = document.getElementById("signup-username");
  let usernameError = document.getElementById("username-error");
  signupUsername.addEventListener("blur", () => {
    regexProvera(signupUsername, usernameError, reUsername, porukaUsername);
  });

  // PROVERA ISPRAVNOSTI PASSWORD-A
  const rePassword = [
    /^[\w\d!@#\$%\^&\*\._]{8,20}$/,
    /^([\w!@#$%^&*._]+[\d]+)|([\d]+[\w!@#\$%\^&\*\._]+)$/,
    /^([\w\d]+[!@#\$%\^&\*\._]+)|([!@#\$%\^&\*\._]+[\w\d]+)$/,
    /^[A-Z][\w\d!@#\$%\^&\*\._]{7,19}$/,
  ];
  const porukaPassword = [
    "Password must be between 8 and 20 characters long and must not contain spaces",
    "Password must contain at least 1 number",
    'Password must contain at least 1 of the characters: "!@#$%^&*._"',
    "Password must start with a capital letter",
  ];
  let passwordError = document.getElementById("password-error");
  let signupPassword = document.getElementById("signup-password");
  signupPassword.addEventListener("blur", () => {
    regexProvera(signupPassword, passwordError, rePassword, porukaPassword);
  });

  // PROVERA ISPRAVNOSTI IMENA I PREZIMENA
  let dodatanReFirstLastName =
    /^[A-Z]([\w\dŽĐŠĆČćđčžšшђжћчЂШЖЋЧ]{2,29}[\d!@#\$%\^&\*\._]+)|([\d!@#\$%\^&\*\._]+[\w\dŽĐŠĆČćđčžšшђжћчЂШЖЋЧ]{2,29})$/;
  const reFirstLastName = [
    /^[\w\dŽĐŠĆČćđčžš]{3,30}$/,
    /^[A-Z][\w\dŽĐŠĆČćđčžšшђжћчЂШЖЋЧ]{2,29}$/,
  ];
  const porukaFirstLastName = [
    "Name (First and Last) must be between 3 and 20 characters long and must not contain spaces",
    "Name (First and Last) must start with a capital letter",
  ];
  let dodatnaPorukaFirstLastName =
    'Name (First and Last) must not contain any numbers or characters: "!@#$%^&*._"';
  let firstNameError = document.getElementById("firstname-error");
  let signupFirstName = document.getElementById("signup-firstname");
  let lastNameError = document.getElementById("lastname-error");
  let signupLastName = document.getElementById("signup-lastname");
  signupFirstName.addEventListener("blur", () => {
    regexProvera(
      signupFirstName,
      firstNameError,
      reFirstLastName,
      porukaFirstLastName,
      dodatanReFirstLastName,
      dodatnaPorukaFirstLastName
    );
  });
  signupLastName.addEventListener("blur", () => {
    regexProvera(
      signupLastName,
      lastNameError,
      reFirstLastName,
      porukaFirstLastName,
      dodatanReFirstLastName,
      dodatnaPorukaFirstLastName
    );
  });

  // PROVERA ISPRAVNOSTI MAIL-A
  const reEmail = [/^[a-z\d\._]{3,29}@[a-z]{3,10}(\.[a-z]{2,5}){1,4}$/];
  const porukaEmail = [
    'Invalid email format (Email must contain "@" and end with a domain name (Ex. ".com")))',
  ];
  let emailError = document.getElementById("email-error");
  let signupEmail = document.getElementById("signup-email");
  signupEmail.addEventListener("blur", () => {
    regexProvera(signupEmail, emailError, reEmail, porukaEmail);
  });

  // PROVERA ISPRAVNOSTI ADRESE
  const reAddress = [
    /^(([A-Z][\w\d\.\-]+)|([\d]+\.?))(\s{1}[\w\d\.\-\/]+)+$/,
    /^(([A-Z][\w\d\.\-]+)|([\d]+\.?))(\s{1}[\w\d\/\.\-]+){0,7}$/,
    /^(([A-Z][\w\d\.\-]+)|([\d]+\.?))(\s{1}[\w\d\/\.\-]+){0,7}\s(([\d]{1,3}((\/(([\d]{1,2}[\w]?)|([\w]{1,2}))|([\w])))?)|((BB)|(bb)))$/,
  ];
  const porukaAddress = [
    "Address must start with either a capital letter, or a number",
    "Address must have a maximum of 8 words",
    "Address must include a number (Ex. 2, 6/a, 30/4b, BB)",
  ];
  let addressError = document.getElementById("address-error");
  let signupAddress = document.getElementById("signup-address");
  signupAddress.addEventListener("blur", () => {
    regexProvera(signupAddress, addressError, reAddress, porukaAddress);
  });

  // PROVERA ISPRAVNOSTI FORME PRITISKOM NA DUGME 'SUBMIT'
  let tacCheckbox = document.getElementById("termsAndConditions");
  let submitButton = document.getElementById("submit-button");
  const objektiPoljeNiz = [
    signupUsername,
    signupPassword,
    signupFirstName,
    signupLastName,
    signupEmail,
    signupAddress,
  ];
  const objektiErrorNiz = [
    usernameError,
    passwordError,
    firstNameError,
    lastNameError,
    emailError,
    addressError,
  ];
  const regexIzrazi = [
    reUsername,
    rePassword,
    reFirstLastName,
    reFirstLastName,
    reEmail,
    reAddress,
  ];
  const porukeNiz = [
    porukaUsername,
    porukaPassword,
    porukaFirstLastName,
    porukaFirstLastName,
    porukaEmail,
    porukaAddress,
  ];
  let greska = false;
  submitButton.addEventListener("click", async () => {
    if (!tacCheckbox.checked) {
      tacCheckbox.classList.add("error-border");
      greska = true;
    } else {
      greska = false;
      tacCheckbox.classList.remove("error-border");
    }
    for (let i = 0; i < 6; i++) {
      if (i == 2 || i == 3) {
        regexProvera(
          objektiPoljeNiz[i],
          objektiErrorNiz[i],
          regexIzrazi[i],
          porukeNiz[i],
          dodatanReFirstLastName,
          dodatnaPorukaFirstLastName
        );
        if (tmpGreska) {
          greska = true;
        }
      } else {
        regexProvera(
          objektiPoljeNiz[i],
          objektiErrorNiz[i],
          regexIzrazi[i],
          porukeNiz[i]
        );
        if (tmpGreska) {
          greska = true;
        }
      }
    }
    if (!greska) {
      let novKorisnik = {
        username: signupUsername.value,
        password: signupPassword.value,
        firstName: signupFirstName.value,
        lastName: signupLastName.value,
        email: signupEmail.value,
        address: signupAddress.value,
        agreedToTOS: tacCheckbox.checked,
      };
      document.getElementById("registerProcess").classList.remove("hide");
      submitButton.disabled = true;
      let msg = await ajaxCall("register.php", "post", {
        novKorisnik,
      });
      if (msg == "confirm") {
        document.getElementById("registerProcess").classList.add("hide");
        document.getElementById("success-signup").classList.remove("hide");
        $("#success-modal .modal-body").html(
          `A confirmation mail has been sent to "${signupEmail.value}"`
        );
        $("#success-modal .modal-header h1").html("");
        $("#success-modal").show();
        $("body").click(function () {
          $("#success-modal").hide();
        });
        submitButton.disabled = true;
      }
    }
  });

  let url = document.location.pathname;
  var urlParams = new URLSearchParams(window.location.search);
  const pageUrl = urlParams.get("page");

  //* * * * * * * * * * * * * * * * * * * * * * * * * * INDEX STRANICA * * * * * * * * * * * * * * * * * * * * * * * * * * *
  if (!pageUrl) {
    // FADEOUT ANIMACIJA WELCOME EKRANA
    let welcomeScreen = document.getElementById("welcome-screen");
    let bgSlike = welcomeScreen.getElementsByTagName("img");
    for (let i = 0; i < bgSlike.length; i++) {
      bgSlike[i].addEventListener("animationend", () => {
        welcomeScreen.appendChild(bgSlike[0]);
      });
    }
    let cartUnavailableMsg = document.getElementById("cart-unavailable");
    let profileUnavailableMsg = document.getElementById("profile-unavailable");
    if (cartUnavailableMsg) {
      toggleErrorModal(cartUnavailableMsg.textContent);
    } else if (profileUnavailableMsg) {
      toggleErrorModal(profileUnavailableMsg.textContent);
    }
  }

  //* * * * * * * * * * * * * * * * * * * * * * * * * * PRODUCTS STRANICA * * * * * * * * * * * * * * * * * * * * * * * * * * *
  // else if (url == "/MaxShoes/products.php") {
  else if (pageUrl == "products") {
    let page = 1;
    function shuffle(niz) {
      let trenutniIndex = niz.length,
        randomIndex;
      while (trenutniIndex != 0) {
        randomIndex = Math.floor(Math.random() * trenutniIndex);
        trenutniIndex--;
        [niz[trenutniIndex], niz[randomIndex]] = [
          niz[randomIndex],
          niz[trenutniIndex],
        ];
      }
      return niz;
    }

    // UZIMANJE SVIH PATIKA IZ BAZE
    let getShoes = true;
    var allShoes = await ajaxCall("filter.php", "post", {
      getShoes,
      page: 1,
    });
    allShoes = shuffle(konvertujPatike(allShoes));

    // ENABLE-OVANJE BOOTSTRAPOVOG TOOLTIP-A ZA KORPE
    $(document).ready(function () {
      $("body").tooltip({
        selector: "#patike-display article a",
      });
    });

    // STAMPANJE, POSTAVLJANJE INICIJALNIH VREDNOSTI I UPDATE-OVANJE VREDNOSTI DUPLOG SLAJDERA
    let prvaCenaGranica = 0,
      drugaCenaGranica = 300;
    let stampajCene = true;
    $(document).ready(function () {
      let $slider = $("#slider-range");
      let priceMin = $slider.attr("data-price-min"),
        priceMax = $slider.attr("data-price-max");

      $slider.slider({
        range: true,
        min: priceMin,
        max: priceMax,
        step: 5,
        values: [priceMin, priceMax],
        slide: function (event, ui) {
          let opseg = "$" + ui.values[0] + " - $" + ui.values[1];
          $("#amount").text("Price range: " + opseg);
          if (stampajCene) {
            dugmadFilter = $(".filter-dugme");
            StampajDugme(opseg, dugmadFilter, "Price range");
          }
          stampajCene = false;
          let dugme = $('.filter-dugme:contains("Price range")');
          if (dugme.length != 0) {
            dugme.contents()[0].textContent = "Price range: " + opseg;
          }
          prvaCenaGranica = ui.values[0];
          drugaCenaGranica = ui.values[1];
        },
      });
      $("#amount").text(
        "Price range: $" +
          $slider.slider("values", 0) +
          " - $" +
          $slider.slider("values", 1)
      );
    });

    let filterDisplay = document.getElementById("filter-display");
    let ukloniFiltre = document.getElementById("ukloni-filtre");
    var dugmadFilter = document.querySelectorAll(".filter-dugme");

    // DODAVANJE EVENT-OVA DROPDOWN LISTAMA ZA STAMPANJE I UPDATE-OVANJE DUGMADI
    const listaBrendova = document.querySelectorAll("#brendovi .dropdown-item");
    const listaSortiranja = document.querySelectorAll(
      "#sortiraj-po .dropdown-item"
    );
    const listaKategorija = document.querySelectorAll(
      "#kategorije-opcije .dropdown-item"
    );
    const listaDodatnihFiltra = document.querySelectorAll(
      '#ostali-filtri input[type="checkbox"]'
    );
    const inputText = document.querySelector("#text-input");
    const applyFilters = document.querySelector("#apply-filters");

    applyFilters.addEventListener("click", function () {
      page = 1;
      stampajBrojStranice();
      glavniFiltar();
    });

    inputText.addEventListener("input", function () {
      let text = inputText.value;
      let stampaj = true;
      dugmadFilter = document.querySelectorAll(".filter-dugme");
      dugmadFilter.forEach((dugme) => {
        if (dugme.textContent.split(": ")[0] == "Keyword") {
          dugme.firstChild.textContent = `Keyword: ${text}`;
          stampaj = false;
          if (text == "") {
            dugme.remove();
          }
        }
      });
      if (stampaj) StampajDugme(text, dugmadFilter, "Keyword");
      dugmadFilter = document.querySelectorAll(".filter-dugme");
      if (dugmadFilter.length < 2) SakrijCistac();
    });

    let kategorijeTekst = Array.from(listaKategorija).map(
      (kategorija) => kategorija.textContent
    );
    let brendoviTekst = Array.from(listaBrendova).map(
      (kategorija) => kategorija.textContent
    );
    let sortirajTekst = Array.from(listaSortiranja).map(
      (kategorija) => kategorija.textContent
    );

    document
      .querySelector("#ostali-filtri")
      .addEventListener("click", function (e) {
        e.stopPropagation();
      });

    listaDodatnihFiltra.forEach(function (filtar) {
      filtar.addEventListener("change", function () {
        let imeFiltra = filtar.dataset.name;
        dugmadFilter = document.querySelectorAll(".filter-dugme");
        if (filtar.checked) {
          StampajDugme(imeFiltra, dugmadFilter);
        } else {
          $(`.filter-dugme:contains(${imeFiltra})`).remove();
          if (dugmadFilter.length < 3) SakrijCistac();
        }
      });
    });

    function dodajEventDdListama(listaOpcija, listaTekstova, key) {
      for (let i = 0; i < listaOpcija.length; i++) {
        listaOpcija[i].addEventListener("click", function () {
          dugmadFilter = document.querySelectorAll(".filter-dugme");
          let opcija = listaOpcija[i].textContent;
          let stampaj = true;
          for (let i = 0; i < dugmadFilter.length; i++) {
            if (
              listaTekstova.includes(dugmadFilter[i].textContent.split(": ")[1])
            ) {
              dugmadFilter[i].firstChild.textContent = `${key}: ${opcija}`;
              stampaj = false;
              break;
            }
          }
          if (stampaj) {
            StampajDugme(opcija, dugmadFilter, key);
          }
        });
      }
    }

    // ANIMACIJA DROPDOWN LISTE ZA FILTRE
    $(document).ready(function () {
      let $dropdowns = $("#filter .nav-link");
      $dropdowns.click(function () {
        $(this).next().slideToggle("fast");
        $dropdowns.not(this).next().slideUp("fast");
      });
      $(document).click(function () {
        $("#filter .padajuci-meni").slideUp("fast");
      });
      $("#filter .nav-link, #dropdown-cena").click(function (e) {
        e.stopPropagation();
      });
    });

    // FUNKCIJA ZA RESETOVANJE SLAJDER-A
    function ResetSlider() {
      $(document).ready(function () {
        stampajCene = true;
        let $slider = $("#slider-range");
        $slider.slider({
          values: [0, 300],
        });
        $("#amount").text("Price range: $0 - $300");
      });
    }

    // FUNKCIJA ZA UKLANJANJE FILTER DUGMETA
    let patikeDisplay = document.getElementById("patike-display");

    function UkloniRoditelja(dugme) {
      dugmadFilter = document.querySelectorAll(".filter-dugme");
      if (dugme.parentElement.textContent.split(" ")[0] == "Price")
        ResetSlider();
      if (dugme.parentElement.textContent == "Free shipping")
        $("#free-shipping").prop("checked", false);
      if (dugme.parentElement.textContent == "On Discount")
        $("#on-discount").prop("checked", false);
      if (dugme.parentElement.textContent.split(": ")[0] == "Keyword")
        $("#text-input").val("");
      dugme.parentElement.remove();
      if (dugmadFilter.length == 2) {
        SakrijCistac();
      }
    }

    // FUNKCIJA ZA SAKRIVANJE CISTAC DUGMETA I UKLANJANJE OSTALIH (PREKO POZIVANJA UkloniRoditelja() FUNKCIJE)
    function SakrijCistac(nizFilterDugmadi = null) {
      ukloniFiltre.classList.add("hide");
      if (nizFilterDugmadi) {
        ResetSlider();
        $("#free-shipping").prop("checked", false);
        $("#on-discount").prop("checked", false);
        $("#text-input").val("");
        while (filterDisplay.childNodes.length > 2) {
          filterDisplay.removeChild(filterDisplay.firstChild);
        }
      }
      page = 1;
      filtriranePatike = allShoes;
      stampajBrojStranice();
      stampajPatike(allShoes);
      patikeDisplay.style.height = "92%";
    }

    // FUNKCIJA ZA STAMPANJE FILTER DUGMETA
    function StampajDugme(opcija, nizFilterDugmadi, key = null) {
      let filterDugme = document.createElement("button");
      filterDugme.classList.add(
        "btn",
        "dark-blue-bg",
        "text-light",
        "ms-3",
        "filter-dugme"
      );
      filterDugme.textContent = key ? `${key}: ${opcija}` : `${opcija}`;
      let closeDugme = document.createElement("button");
      closeDugme.classList.add("btn-close", "ms-2", "ukloni-dugme");
      closeDugme.addEventListener("click", function () {
        UkloniRoditelja(closeDugme, nizFilterDugmadi);
      });
      filterDugme.appendChild(closeDugme);
      filterDisplay.insertBefore(filterDugme, nizFilterDugmadi[0]);
      ukloniFiltre.classList.remove("hide");
      if (window.innerWidth < 531) {
        patikeDisplay.style.height = "75%";
      } else if (window.innerWidth < 869) {
        patikeDisplay.style.height = "80%";
      } else if (window.innerWidth < 1000) {
        patikeDisplay.style.height = "85%";
      } else {
        patikeDisplay.style.height = "87%";
      }
    }

    // SELEKTOVANJE I DODAVANJE EVENT-A CISTAC DUGMETU
    let dugmeSakrijCistaca = document.querySelector("#ukloni-filtre");
    dugmeSakrijCistaca.addEventListener("click", function () {
      SakrijCistac(dugmadFilter);
    });

    let filtriranePatike = allShoes;
    // FUNKCIJA ZA FILTRIRANJE PATIKA
    async function glavniFiltar() {
      let data = {};
      dugmadFilter = document.querySelectorAll(".filter-dugme");
      if (dugmadFilter.length < 1) return;
      dugmadFilter.forEach((dugme) => {
        let filtar = dugme.textContent.split(": ")[0];
        let filtar2 = dugme.textContent.split(": ")[1];
        if (filtar2 == undefined || filtar == "Keyword") {
          if (filtar == "Free shipping") {
            data["FreeShipping"] = true;
          } else if (filtar == "On Discount") {
            data["OnDiscount"] = true;
          } else if (filtar == "Keyword") {
            data[filtar] = filtar2;
          }
        } else {
          if (filtar2.substring(0, 1) == "$") {
            data["donjaCena"] = prvaCenaGranica;
            data["gornjaCena"] = drugaCenaGranica;
          } else if (filtar == "Sort By") {
            data["SortBy"] = filtar2;
          } else {
            data[filtar] = filtar2;
          }
        }
      });
      data.getShoes = true;
      data.page = page;
      filtriranePatike = konvertujPatike(
        await ajaxCall("filter.php", "post", data)
      );
      stampajBrojStranice();
      stampajPatike(filtriranePatike);
    }

    // STAMPANJE PATIKA
    async function stampajPatike(shoeList) {
      let svePatike = document.querySelectorAll(".shoe");
      svePatike.forEach((patika) => {
        patika.remove();
      });
      let idDodatihPatika = Array.from(
        document.querySelectorAll(".shoe-data")
      ).map((el) => parseInt(el.textContent));
      if (shoeList.length == 0) {
        patikeDisplay.innerHTML = `<div class="alert alert-danger mt-3 p-4 rounded-pill d-flex align-items-center justify-content-center text-center" id="no-shoes">
                <h2>Sorry, no shoes matching your filters</h2></div>`;
        return;
      }
      patikeDisplay.innerHTML = "";
      for (let shoe of shoeList) {
        let bgColor;
        if (shoe.kategorija_naziv == "Men") bgColor = "dark-blue-bg text-white";
        if (shoe.kategorija_naziv == "Women") bgColor = "pink-bg text-dark";
        if (shoe.kategorija_naziv == "Kids") bgColor = "lgreen-bg text-dark";
        patikeDisplay.innerHTML += `
                <article class="shoe mt-4 container">
                <img src="${shoe.slika_src}" alt="${
          shoe.slika_alt
        }" class="img-fluid">
                <strong class="d-block">${shoe.brend_naziv} ${
          shoe.patika_model
        }</strong>
                <i class="d-inline-block ${bgColor} w-75 rounded">${
          shoe.kategorija_naziv
        }</i>
                <div id="shoe-price">
                ${
                  shoe.popust
                    ? "<p class='text-decoration-line-through d-inline mx-2 text-danger fst-italic'>$" +
                      shoe.bazna_cena +
                      "</p>" +
                      "<p class='d-inline text-success fw-bold'>$" +
                      shoe.snizena_cena +
                      "<strong class='d-inline text-black fst-italic'>(" +
                      Math.round((1 - shoe.popust) * 100) +
                      "% off!)</strong>"
                    : "<p>$" + shoe.bazna_cena + "</p>"
                }
                </div>
                ${
                  shoe.cena_postarine
                    ? "<i id='text-shipping' class='bg-dark d-inline-block text-white p-3 rounded-pill'>Shipping: $" +
                      shoe.cena_postarine +
                      "</i>"
                    : '<img src="Assets/img/free-shipping.png" alt="free shipping" class="img-fluid" id="free-shipping-img">'
                }    
                
                <a data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Add to cart" class="korpa-roditelj">
                <svg data-id="${
                  shoe.patika_id
                }" xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-cart3 korpa ${
          idDodatihPatika.includes(shoe.patika_id) ? "crvena" : "plava"
        }" viewBox="0 0 16 16" data-bs-title="Remove from cart">
        <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .49.598l-1 5a.5.5 0 0 1-.465.401l-9.397.472L4.415 11H13a.5.5 0 0 1 0 1H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM3.102 4l.84 4.479 9.144-.459L13.89 4H3.102zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"></path></svg></a></article>
                `;
      }
      if (document.getElementById("isLoggedIn")) {
        dodajEventKorpama(shoeList);
      } else {
        $(".korpa-roditelj").attr("data-bs-toggle", "modal");
        $(".korpa-roditelj").attr("href", "#account-modal");
      }
    }

    // STAMPANJE BROJ STRANICE
    let prevBtn = document.querySelector("#prev");
    let nextBtn = document.querySelector("#next");

    function stampajBrojStranice() {
      console.log(page);
      console.log(filtriranePatike.length);
      prevBtn.textContent = `Page ${page - 1}`;
      nextBtn.textContent = `Page ${page + 1}`;
      if (page == 1) {
        prevBtn.classList.add("disabled", "hidden");
      } else {
        prevBtn.classList.remove("disabled", "hidden");
      }
      if (filtriranePatike.length < 10) {
        nextBtn.classList.add("disabled", "hidden");
      } else {
        nextBtn.classList.remove("disabled", "hidden");
      }
    }

    [prevBtn, nextBtn].forEach((btn) => {
      btn.addEventListener("click", () => {
        if (btn.classList.contains("disabled")) return;
        page = parseInt(btn.textContent.split(" ")[1]);
        glavniFiltar();
      });
    });

    stampajBrojStranice();
    // INICIJALNO POKRETANJE STAMPANJA
    const categoryUrl = urlParams.get("category");
    const brandUrl = urlParams.get("brand");
    const modelUrl = urlParams.get("model");
    const discountUrl = urlParams.get("discount");
    if (categoryUrl) {
      StampajDugme(categoryUrl, dugmadFilter, "Category");
    }
    if (modelUrl) {
      StampajDugme(modelUrl, dugmadFilter, "Model");
    }
    if (brandUrl) {
      StampajDugme(brandUrl, dugmadFilter, "Brand");
    }
    if (discountUrl) {
      $("#on-discount").prop("checked", true);
      StampajDugme(discountUrl, dugmadFilter);
    }
    dodajEventDdListama(listaBrendova, brendoviTekst, "Brand");
    dodajEventDdListama(listaKategorija, kategorijeTekst, "Category");
    dodajEventDdListama(listaSortiranja, sortirajTekst, "Sort By");
    if (categoryUrl || modelUrl || brandUrl || discountUrl) {
      glavniFiltar();
    } else {
      stampajPatike(allShoes);
    }
  }

  //* * * * * * * * * * * * * * * * * * * * * * * * * * CART STRANICA * * * * * * * * * * * * * * * * * * * * * * * * * * *//
  else if (pageUrl == "cart") {
    let total = 0;
    let idDodatihPatika = Array.from(
      document.querySelectorAll(".shoe-data")
    ).map((el) => parseInt(el.textContent));
    let data = {
      getShoes: true,
      ids: idDodatihPatika,
    };
    var stavkeUKorpi;
    if (idDodatihPatika[0]) {
      stavkeUKorpi = konvertujPatike(
        await ajaxCall("filter.php", "post", data)
      );
    }

    function stampajKorpu(stavkeUKorpi) {
      total = 0;
      let korpaDrzac = document.querySelector("#korpa-drzac");
      let totalText = document.getElementById("total");
      if (!stavkeUKorpi || stavkeUKorpi.length == 0) {
        korpaDrzac.innerHTML = `<div class="alert alert-danger mt-3 p-4 rounded-pill d-flex align-items-center justify-content-center text-center" id="no-shoes">
                <h2>You don't have any items in your cart</h2></div>`;
        totalText.innerHTML = `Total: $0.00`;
        document.querySelectorAll("#korpa-info button").forEach((button) => {
          button.disabled = true;
        });
        return;
      }
      document.querySelectorAll("#korpa-info button").forEach((button) => {
        button.disabled = false;
      });
      let html = "";
      for (let stavka of stavkeUKorpi) {
        total += stavka.cena_postarine
          ? stavka.snizena_cena + stavka.cena_postarine
          : stavka.snizena_cena;
        let bgColor;
        if (stavka.kategorija_naziv == "Men")
          bgColor = "dark-blue-bg text-white";
        if (stavka.kategorija_naziv == "Women") bgColor = "pink-bg text-dark";
        if (stavka.kategorija_naziv == "Kids") bgColor = "lgreen-bg text-dark";
        html += `
                <div class="row border stavka my-2 d-flex">
                <i class="fa-solid fa-trash obrisi-stavku" data-id="${
                  stavka.patika_id
                }"></i>

                <div class="col-md-5 d-flex flex-column border-bottom p-2">
                <hgroup>
                <h2 class="text-decoration-underline">${stavka.brend_naziv} ${
          stavka.patika_model
        }</h2>
                <i class="${bgColor} p-2 my-1 d-inline-block rounded">${
          stavka.kategorija_naziv
        }</i>
                </hgroup>
                </div>
                <div class="col-md-3 d-flex flex-column border-bottom p-2">
                <h2 class="text-decoration-underline">Price:</h2>
                ${
                  stavka.popust
                    ? "<hgroup><h5 class='text-decoration-line-through d-inline text-danger fst-italic'>$" +
                      stavka.bazna_cena +
                      "</h5>" +
                      "<h5 class='d-inline text-success fw-bold mx-2'>$" +
                      stavka.snizena_cena +
                      "</h5></hgroup>"
                    : "<h5>$" + stavka.bazna_cena + "</h5>"
                }
                <p>+$${
                  stavka.cena_postarine ? stavka.cena_postarine : "0.00"
                } shipping</p>
                </div>
                <div class="col-md-4 d-flex border-bottom">
                <img class="img-fluid p-2" src="${stavka.slika_src}" alt="${
          stavka.slika_alt
        }">
                </div>
                </div>
                `;
      }
      totalText.innerHTML = `Total: $${total}.00`;
      korpaDrzac.innerHTML = html;
      dodajEventKantama(stavkeUKorpi);
    }

    function dodajEventKantama(stavkeUKorpi) {
      document.querySelectorAll(".obrisi-stavku").forEach((dugme) => {
        dugme.addEventListener("click", async function () {
          let shoeToRemove = stavkeUKorpi.find(
            (stavka) => stavka.patika_id == dugme.dataset.id
          );
          stavkeUKorpi = stavkeUKorpi.filter(
            (stavka) => stavka.patika_id != shoeToRemove.patika_id
          );
          await ajaxCall("cartmanager.php", "post", {
            shoeToRemove,
          });
          stampajKorpu(stavkeUKorpi);
          stampajBrojac(stavkeUKorpi.length, -1);
        });
      });
    }

    async function brisiSveIzKorpe() {
      let removeAll = true;
      await ajaxCall("cartmanager.php", "post", {
        removeAll,
      });
      stavkeUKorpi = [];
      stampajKorpu(stavkeUKorpi);
      stampajBrojac(0, -1);
    }

    document.querySelector("#clear").addEventListener("click", brisiSveIzKorpe);
    document
      .querySelector("#purchase")
      .addEventListener("click", async function () {
        let makeAnOrder = true;
        await ajaxCall("insertorder.php", "post", {
          makeAnOrder,
        });
        brisiSveIzKorpe();
        $("#success-modal .modal-body").html(
          "Purchase successfull, redirecting to profile page..."
        );
        $("#success-modal .modal-header h1").html("Success!");
        $("#success-modal").show();
        setTimeout(function () {
          window.location.href = "profile.php";
        }, 1000);
      });
    stampajKorpu(stavkeUKorpi);
  }

  //* * * * * * * * * * * * * * * * * * * * * * * * * * PROFILE STRANICA * * * * * * * * * * * * * * * * * * * * * * * * * * *//
  else if (pageUrl == "profile") {
    let submitVote = document.getElementById("submitVote");
    submitVote.addEventListener("click", async function (event) {
      event.preventDefault();
      const selectedValue = document.querySelector(
        'input[type="radio"]:checked'
      );
      if (selectedValue) {
        document.getElementById("anketa-error").classList.add("hide");
        let idGlas = selectedValue.id;
        let brojGlasova = await ajaxCall("anketa.php", "post", {
          submitVote: true,
          idGlas,
        });
        document.getElementById("anketa-success").classList.remove("hide");
        submitVote.disabled = true;
        document
          .querySelectorAll('input[type="radio"]')
          .forEach(function (radio) {
            radio.disabled = true;
            let glasoviIzbora = brojGlasova.find((glas) => glas.id == radio.id);
            if (radio.checked) {
              radio.setAttribute("checked", "");
              radio.parentElement.innerHTML += `<p class='d-inline-block m-0'>(${glasoviIzbora.broj_glasova} votes) <i>Your vote</i></p>`;
            } else {
              radio.parentElement.innerHTML += `<p class='d-inline-block m-0'>(${glasoviIzbora.broj_glasova} votes)</p>`;
            }
          });
      } else {
        document.getElementById("anketa-error").classList.remove("hide");
      }
    });
  }
  //* * * * * * * * * * * * * * * * * * * * * * * * * * ADMIN STRANICA * * * * * * * * * * * * * * * * * * * * * * * * * * *//
  else if (pageUrl == "adminpanel") {
    let modalErrMsg = document.querySelector(".modalErrMsg");
    if (modalErrMsg) {
      modalErrMsg.style.display = "block";
      modalErrMsg.addEventListener("click", function () {
        modalErrMsg.style.display = "none";
      });
    }
    let modalSuccMsg = document.querySelector(".modalSuccMsg");
    if (modalSuccMsg) {
      modalSuccMsg.style.display = "block";
      modalSuccMsg.addEventListener("click", function () {
        modalSuccMsg.style.display = "none";
      });
    }
    document
      .getElementById("insertShoe")
      .addEventListener("click", function () {
        document.getElementById("insertProcess").classList.remove("hide");
      });
    document
      .getElementById("updateShoe")
      .addEventListener("click", function () {
        document.getElementById("updateProcess").classList.remove("hide");
      });
    document
      .getElementById("deleteShoe")
      .addEventListener("click", function () {
        document.getElementById("deleteProcess").classList.remove("hide");
      });
    var allShoes = konvertujPatike(
      await ajaxCall("filter.php", "post", {
        getShoes: true,
      })
    );

    const distinctCategories = [
      ...new Set(allShoes.map((obj) => obj.kategorija_naziv)),
    ];
    const distinctBrands = [
      ...new Set(allShoes.map((obj) => obj.brend_naziv)),
    ].sort();
    let shoeDisplayed;
    let shoeUpdateDisplay = document.getElementById("shoe-update-display");
    let shoeChoiceDd = document.getElementById("shoeid-update");
    let shoeIdInput = document.getElementById("id-selected");

    async function displayShoe(ddlShoes, shoeDisplay, id) {
      shoeDisplayed = allShoes.find(
        (shoe) => shoe.patika_id == parseInt(ddlShoes.value)
      );
      if (!shoeDisplayed) {
        shoeDisplay.innerHTML = "";
        id.value = "";
        return;
      }
      shoeDisplay.innerHTML = `
            <div class="d-flex justify-content-center" id="slika-update-drzac"><img
            src="${shoeDisplayed.slika_src}" alt=${
        shoeDisplayed.slika_alt
      }></div>
    <div class="p-1 d-flex flex-column ">
        <ul class="list-group">
            <li class="list-group-item">
                <p class="d-inline fw-bold">Brand:</p> ${
                  shoeDisplayed.brend_naziv
                }
            </li>
            <li class="list-group-item">
                <p class="d-inline fw-bold">Model:</p> ${
                  shoeDisplayed.patika_model
                }
            </li>
            <li class="list-group-item">
                <p class="d-inline fw-bold">Category:</p> ${
                  shoeDisplayed.kategorija_naziv
                }
            </li>
            <li class="list-group-item">
                <p class="d-inline fw-bold">Price (base): $</p>${
                  shoeDisplayed.bazna_cena
                }
            </li>
            ${
              shoeDisplayed.popust
                ? '<li class="list-group-item"><p class="d-inline fw-bold">Discount: </p>' +
                  shoeDisplayed.popust +
                  " (" +
                  Math.round(100 * (1 - shoeDisplayed.popust)) +
                  "%)</li>"
                : '<li class="list-group-item"><p class="d-inline fw-bold">Discount:</p> N/A</li>'
            }
        ${
          shoeDisplayed.cena_postarine
            ? '<li class="list-group-item"><p class="d-inline fw-bold">Shipping: $</p>' +
              shoeDisplayed.cena_postarine +
              "</li>"
            : '<li class="list-group-item"><p class="d-inline fw-bold">Shipping:</p> Free</li>'
        }
        </ul>
    </div>`;
      id.value = shoeDisplayed.patika_id;
    }
    shoeChoiceDd.addEventListener("change", function () {
      displayShoe(shoeChoiceDd, shoeUpdateDisplay, shoeIdInput);
    });

    let filterDiv = document.getElementById("update-filters");
    let updateShoe = document.getElementById("updateShoe");
    const updateForm = document.getElementById("update-form");
    filterDiv.addEventListener("change", (event) => {
      const checkboxId = event.target.id;

      if (event.target.checked) {
        let divForm = document.createElement("div");
        divForm.classList.add("form-group", "my-2");
        switch (checkboxId) {
          case "category-chb-update":
            divForm.setAttribute("id", "category-selected");
            let categoriesHtml = "";
            for (let cat of distinctCategories) {
              categoriesHtml +=
                '<option value="' +
                (parseInt(distinctCategories.indexOf(cat)) + 1) * 1 +
                '">' +
                cat +
                "</option>";
            }
            divForm.innerHTML = `<div class="d-flex justify-content-between"><label
                        for="category-update">Category:</label></div>
                <select class="form-control my-1" name="category-update" id="category-update">
                    <option value="0">Choose a category</option>
                    ${categoriesHtml}
                </select>`;
            updateForm.insertBefore(divForm, updateShoe);
            break;
          case "brand-chb-update":
            divForm.setAttribute("id", "brand-selected");
            let brandsHtml = "";
            for (let brand of distinctBrands) {
              brandsHtml +=
                '<option value="' +
                (parseInt(distinctBrands.indexOf(brand)) + 1) * 1 +
                '">' +
                brand +
                "</option>";
            }
            divForm.innerHTML = `<div class="d-flex justify-content-between"><label
                        for="brand-update">Brand:</label></div>
                <select class="form-control my-1" name="brand-update" id="brand-update">
                    <option value="0">Choose a brand</option>
                    ${brandsHtml}
                </select>`;
            updateForm.insertBefore(divForm, updateShoe);
            break;
          case "model-chb-update":
            divForm.setAttribute("id", "model-selected");
            divForm.innerHTML = `<div class="form-group my-2">
                        <div class="d-flex justify-content-between"><label for="model-update">Model name (format
                                varchar(50)):</label>
                        </div>
                        <input type="text" placeholder="Between 3 and 50 characters" name="model-update"
                            class="form-control my-1" id="model-update"></div>`;
            updateForm.insertBefore(divForm, updateShoe);
            break;
          case "price-chb-update":
            divForm.setAttribute("id", "price-selected");
            divForm.innerHTML = `<div class="form-group my-2">
                        <div class="d-flex justify-content-between"><label for="price-update">Shoe price (format
                                Decimal(6,2)):</label>
                        </div>
                        <input type="number" placeholder="Between 10 and 999 dollars" name="price-update"
                            class="form-control my-1" id="price-update">
                        </div>`;
            updateForm.insertBefore(divForm, updateShoe);
            break;
          case "disc-chb-update":
            divForm.setAttribute("id", "disc-selected");
            divForm.innerHTML = `<div class="form-group my-2 border p-2">
                        <label for="discount-update">Discount (format Decimal(3,2), leave blank for no discount/End current discount):</label>
                        <input type="number" step="0.01" placeholder="Example: 0.70 if you want 30% discount"
                            name="discount-update" class="form-control my-1" id="">
                    </div>`;
            updateForm.insertBefore(divForm, updateShoe);
            break;
          case "shipping-chb-update":
            divForm.setAttribute("id", "shipping-selected");
            divForm.innerHTML = `<div class="form-group my-2">
                        <label for="shipping-update">Shipping price (format Decimal(6,2), leave blank for free
                            shipping):</label>
                        <input type="number" placeholder="Between 0 and 999 dollars" name="shipping-update"
                            class="form-control my-1" id="shipping-update">
                    </div>`;
            updateForm.insertBefore(divForm, updateShoe);
            break;
          case "img-chb-update":
            divForm.setAttribute("id", "img-selected");
            divForm.innerHTML = `<div class="form-group my-2">
                        <div class="d-flex justify-content-between"><label for="file-update">Image (1 file per
                                shoe, supported formats JPG, PNG, JPEG):</label>
                        </div>
                        <input type="file" name="file-update" class="form-control-file my-1" id="file-update">
                    </div>`;
            updateForm.insertBefore(divForm, updateShoe);
            break;
          default:
            updateForm.innerHTML += "";
            break;
        }
      } else {
        switch (checkboxId) {
          case "category-chb-update":
            document.getElementById("category-selected").remove();
            break;
          case "brand-chb-update":
            document.getElementById("brand-selected").remove();
            break;
          case "model-chb-update":
            document.getElementById("model-selected").remove();
            break;
          case "price-chb-update":
            document.getElementById("price-selected").remove();
            break;
          case "disc-chb-update":
            document.getElementById("disc-selected").remove();
            break;
          case "shipping-chb-update":
            document.getElementById("shipping-selected").remove();
            break;
          case "img-chb-update":
            document.getElementById("img-selected").remove();
            break;
          default:
            break;
        }
      }
    });

    let shoeDeleteDisplay = document.getElementById("shoe-delete-display");
    let shoeChoiceDdDelete = document.getElementById("shoeid-delete");
    let shoeIdInputDelete = document.getElementById("id-selected-delete");
    shoeChoiceDdDelete.addEventListener("change", function () {
      displayShoe(shoeChoiceDdDelete, shoeDeleteDisplay, shoeIdInputDelete);
    });

    // DOHVATANJE STATISTIKE O POSETAMA I POSTAVLJANJE VELICINE DIV-A NA OSNOVU PODATAKA
    let visitsPerPage = await ajaxCall("getVisitsPerPage.php", "GET");
    document.querySelector("#chart-index").style.height =
      300 * visitsPerPage.index + "px";
    document.querySelector("#chart-products").style.height =
      300 * visitsPerPage.products + "px";
    document.querySelector("#chart-cart").style.height =
      300 * visitsPerPage.cart + "px";
    document.querySelector("#chart-profile").style.height =
      300 * visitsPerPage.profile + "px";
  }
};

// FUNKCIJA ZA PROVERU ISPRAVNOSTI UNETOG TEKSTA POMOCU REGULARNIH IZRAZA
function regexProvera(
  objekatPolje,
  errorTekst,
  regexNiz,
  porukaNiz,
  dodatanRegex = null,
  dodatnaPoruka = null
) {
  for (let i = 0; i < porukaNiz.length; i++) {
    if (!objekatPolje.value) {
      errorTekst.classList.add("hide");
      objekatPolje.classList.add("error-border");
      tmpGreska = true;
      break;
    } else if (dodatanRegex && dodatanRegex.test(objekatPolje.value)) {
      objekatPolje.classList.add("error-border");
      errorTekst.textContent = dodatnaPoruka;
      errorTekst.classList.remove("hide");
      tmpGreska = true;
      break;
    } else if (!regexNiz[i].test(objekatPolje.value)) {
      objekatPolje.classList.add("error-border");
      errorTekst.textContent = porukaNiz[i];
      errorTekst.classList.remove("hide");
      tmpGreska = true;
      break;
    } else {
      objekatPolje.classList.remove("error-border");
      errorTekst.classList.add("hide");
      tmpGreska = false;
    }
  }
}

function toggleErrorModal(msg) {
  $("#error-modal .modal-body").html(msg);
  $("#error-modal").show();
  $("body").click(function () {
    $("#error-modal").hide();
  });
}

function konvertujPatike(shoes) {
  let convertedShoes = shoes.map((shoe) => {
    return {
      ...shoe,
      patika_id: parseInt(shoe.patika_id),
      bazna_cena: parseInt(shoe.bazna_cena),
      cena_postarine: shoe.cena_postarine
        ? parseInt(shoe.cena_postarine)
        : null,
      popust: shoe.popust ? parseFloat(shoe.popust) : null,
      snizena_cena: parseInt(shoe.snizena_cena),
    };
  });
  return convertedShoes;
}

// AJAX FUNKCIJA
function ajaxCall(stranica, metod, data = null) {
  return $.ajax({
    url: "models/" + stranica,
    method: metod,
    data: data,
    success: function (rezultat) {
      return rezultat;
    },
    error: function (jqXHR, exception) {
      var msg;
      if (jqXHR.statusCode === 500) {
        msg = "Internal server error [500]";
      } else {
        msg = jqXHR.responseText;
      }
      console.log(jqXHR);
      console.log(exception);
      // var msg = jqXHR.responseText;

      // $('#ajax-error').css("opacity", 1).html("Error:" + msg);
      document.getElementById("loginSubmit").disabled = false;
      document.getElementById("submit-button").disabled = false;
      document.getElementById("loginProcess").classList.remove("hide");
      document.getElementById("loginProcess").classList.add("hide");
      document.getElementById("registerProcess").classList.remove("hide");
      document.getElementById("registerProcess").classList.add("hide");
      toggleErrorModal(msg);
    },
  });
}

// FUNKCIJA ZA STAMPANJE BROJA ARTIKLA U KORPI
let ikonice = document.querySelectorAll(".icons a svg");
let brojacOkvir = document.getElementById("brojac");
let navbar = document.querySelector(".navbar-meni");

function stampajBrojac(brojac, promena) {
  if (brojac > 1 || (brojac == 1 && promena == -1)) {
    brojacOkvir.classList.remove("hide");
    brojacOkvir.textContent = brojac;
  } else if (brojac == 0) {
    if (window.innerWidth < 456) {
      navbar.style.padding = "5px 0 0 0";
    }
    brojacOkvir.classList.add("hide");
    ikonice.forEach((ikonica) => {
      ikonica.style.marginTop = "0px";
    });
    brojacOkvir.textContent = brojac;
  } else if (brojac == 1 && promena == 1) {
    if (window.innerWidth < 456) {
      navbar.style.padding = "0 0 0 0";
    }
    brojacOkvir.classList.remove("hide");
    brojacOkvir.textContent = brojac;
  }
}

// FUNKCIJA ZA DODAVANJE I IZBACIVANJE IZ KORPE ZA SVAKI PRODUKT
function dodajEventKorpama(shoeList) {
  $(document).ready(function () {
    $(this).attr("data-bs-title", "Remove from cart");
    $(".korpa").click(async function () {
      let brojUKorpi = parseInt(brojacOkvir.textContent);
      if (!brojUKorpi) brojUKorpi = 0;
      if ($(this).hasClass("plava")) {
        let shoeToAdd = shoeList.find(
          (shoe) => shoe.patika_id == this.dataset.id
        );
        await ajaxCall("cartmanager.php", "post", {
          shoeToAdd,
        });
        brojUKorpi++;
        stampajBrojac(brojUKorpi, 1);
        $(this).removeClass("plava");
        $(this).addClass("crvena");
        $(this).parent().tooltip("disable");
        $(this).tooltip("enable");
        $("#uspesno-dodato")
          .animate(
            {
              bottom: "4%",
              opacity: "100",
            },
            500
          )
          .animate(
            {
              opacity: "0",
            },
            {
              duration: 1500,
            }
          )
          .animate(
            {
              bottom: "-12%",
            },
            {
              duration: 0,
            }
          );
      } else {
        let shoeToRemove = shoeList.find(
          (shoe) => shoe.patika_id == this.dataset.id
        );
        await ajaxCall("cartmanager.php", "post", {
          shoeToRemove,
        });
        brojUKorpi--;
        stampajBrojac(brojUKorpi, -1);
        $(this).removeClass("crvena");
        $(this).addClass("plava");
        $(this).tooltip("disable");
        $(this).parent().tooltip("enable");
        $("#uspesno-skinuto")
          .animate(
            {
              bottom: "4%",
              opacity: "100",
            },
            500
          )
          .animate(
            {
              opacity: "0",
            },
            {
              duration: 1500,
            }
          )
          .animate(
            {
              bottom: "-12%",
            },
            {
              duration: 0,
            }
          );
      }
    });
  });
}
