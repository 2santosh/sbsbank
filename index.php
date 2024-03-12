<html>
<title>SBS Bank</title>

<head>
    <link rel="stylesheet" type="text/css" href="css/index.css">
    <link rel="shortcut icon" href="img/logoTitle.jpg">
    
</head>

<body>
    <?php include 'header.php' ?>

    <div class="index_container">
        <div class="slider">
            <div class="slideimg">
                <img src="img/slide.jpg">
                <img src="img/slide1.jpg">
                <img src="img/slide2.jpg">
                <img src="img/slide3.jpg">
            </div>
        </div><br>
        <div class="newsroom">

            <marquee class="marquee_news" scrolldelay="20">
                <p class="newsfeed"><span>Your bank may charge you for closing a bank account.
                        Bank also charges you when you close your account within a particular time period.</span><span>SBI cuts deposit rates; PPF to fetch lower interest rate. </span><span>No, it is not mandatory to link your bank account with CITIZENSHIP card</span></p>
            </marquee>
        </div><br><br>


        <div class="news_events">
            <h4>Tips | Updates | Events</h4><br>
            <ul>
                <p>First, open an account. Then apply for a debit card to get further details.
                </p><br>
                <p>And finally, proceed for Internet Banking Registration to create your internet banking account.

                </p>
                <br>
            </ul>
        </div>


        <div id="iservices" class="online_services">
            <h4>Online Services</h4>
            <ul>
                <a href="client/pages_client_signup.php">
                    <li>Open Account</li>
                </a>
                <a href="debit_card_form.php">
                    <li>Apply Debit Card</li>
                </a><br>
                <a href="" id="ebanking">
                    <li>
                        <div class="ebanking">Internet Banking
                            <div class="ebanking_options">
                                <ul>
                                    <a href="client/pages_client_index.php">
                                        <li>Login </li>
                                    </a>
                                    <a href="client/pages_client_signup.php">
                                        <li>Register</li>
                                    </a>
                                </ul>
                            </div>
                        </div>
                    </li>
                </a>
                <a href="fund_transfer.php">
                    <li>Fund Transfer</li>
                </a><br>
            </ul>

        </div>

        <div id="aboutus" class="about"><span>About Us</span><br><br>
            <p>The banking system encompasses a network of financial institutions that accept deposits, provide loans, facilitate payments, issue credit cards, and offer investment services. It includes various types of banks, operates within regulatory frameworks, and adapts to technological advancements while maintaining its fundamental role in economic growth and financial intermediation
            </p>
        </div>

        <div class="disclaimer">
            <span>Disclaimer !!</spasn><br><br>
                <p>Our bank does not ask for the details of your account/PIN/password. Therefore any one pretending to be asking you for information from the bank/technical team may be fraudulent entities, so please beware.</p>
                <p>You should know how to operate net transactions and if you are not familiar you may refrain from doing so. You may seek bank's guidance in this regard. Bank is not responsible for online transactions going wrong.</p>
                <p>We shall also not be responsible for wrong transactions and wanton disclosure of details by you. Viewing option and transaction option on the net are different. You may exercise your option diligently.</p>
        </div>

        <div id="messageBox">
    <span class="close" onclick="hideMessage()">&times;</span>
    <p id="messageContent"></p>
</div>

    </div>
    <script>
   function showMessage(action) {
        var message;
        switch(action) {
            case 'Deposit':
                message = '<br>A deposit is a financial transaction where money is placed into a bank account for safekeeping or to earn interest. Types include savings, checking, time, demand, and fixed deposits. Deposits provide safe storage, interest earnings, and facilitate convenient transactions. Deposit insurance schemes protect depositors in case of bank failures. Banks and other depository institutions accept deposits and play a vital role in financial intermediation. Regulatory oversight ensures the safety and soundness of the banking system.';
                break;
            case 'Loan':
                message = '<br>A loan is a financial transaction where one party, typically a bank or lender, provides money to another party, usually an individual or business, with the expectation that it will be repaid with interest over a predetermined period. Types of loans include personal loans, mortgages, auto loans, and business loans. Loans provide access to funds for various purposes such as purchasing assets, funding education, or expanding businesses. Borrowers are typically required to pay back the principal amount along with interest according to agreed-upon terms and conditions. Loans play a crucial role in stimulating economic activity by providing capital for investment and consumption. Regulatory oversight ensures responsible lending practices and protects both borrowers and lenders.';
                break;
            case 'Remittance':
                message = '<br>Remittance refers to the transfer of money from one party to another, either domestically or internationally, typically for personal or commercial purposes. Methods include bank transfers, online platforms, and cash pickups. Remittances support families, businesses, and economic development, and are subject to regulatory oversight to prevent illegal activities.';
                break;
            default:
                message = 'Action not recognized.';
        }
        document.getElementById("messageContent").innerHTML = message;
        document.getElementById("messageBox").style.display = "block";
    }

    function hideMessage() {
        document.getElementById("messageBox").style.display = "none";
    }

    function toggleDropdown() {
        var dropdown = document.getElementById("dropdown");
        dropdown.classList.toggle("show");
    }

    window.onclick = function(event) {
        if (!event.target.matches('.dropbtn')) {
            var dropdowns = document.getElementsByClassName("dropdown-content");
            for (var i = 0; i < dropdowns.length; i++) {
                var openDropdown = dropdowns[i];
                if (openDropdown.classList.contains('show')) {
                    openDropdown.classList.remove('show');
                }
            }
        }
    }
</script>

    <?php include 'footer.php'; ?>
</body>

</html>