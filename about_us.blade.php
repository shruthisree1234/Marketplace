<!DOCTYPE html>
<html>
  <meta name="viewport" content="width=device-width, initial-scale=1">
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
        <!--Import Google Icon Font-->
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <!--Import materialize.css-->
        <link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>
  
        <!--Let browser know website is optimized for mobile-->
<title>About Us Page</title>
<style>
  /* Team-23:
Thirunavukkarasu Shruthi Sree-1001933428
Vanja-Tulasi- 1002029536
Vishnu Alekhya-1001995174
Vinjam Nishanth-1002030184 
*/
img{
  width:60px;
  height:60px;
  margin: 0% 1%;
  }
  .nav-wrapper{
   background-color: rgb(66, 66, 68);
  }
  a{
  text-decoration:none;
  color:rgb(243, 238, 238);
  font-family:sans-serif;
  font-weight:bold;
  }
  a:active{
  color:silver;
  }
  body{
    background: url("https://visme.co/blog/wp-content/uploads/2017/07/50-Beautiful-and-Minimalist-Presentation-Backgrounds-032.jpg");
    color:rgb(243, 238, 238);
    font-family: Marker Felt, fantasy;
    margin: 10;
  }
  
  html {
    box-sizing: border-box;
  }
  
  *, *:before, *:after {
    box-sizing: inherit;
  }
  
  .column {
    float: left;
    width: 30%;
    margin-bottom: 50px;
    padding: 0 8px;
  }
  
  .card {
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
    margin: 10px;
    background-color: rgb(230, 140, 30);
  }
  
  .about-section {
    padding: 70px;
    text-align: left;
    background-image: url("https://visme.co/blog/wp-content/uploads/2017/07/50-Beautiful-and-Minimalist-Presentation-Backgrounds-032.jpg");
    color: white;
  }
  
  .container {
    padding: 20px;
    background-color: rgb(230, 140, 30);
  }
  
  .container::after, .row::after {
    content: "";
    clear: both;
    display: table;
  }
  
  .title {
    color: rgb(14, 12, 12);
  }
  
  .button {
    border: none;
    outline: 0;
    display: inline-block;
    padding: 8px;
    color: white;
    background-color: #000;
    text-align: center;
    cursor: pointer;
    width: 100%;
  }
  
  .button:hover {
    background-color: #555;
  }
  
  @media screen and (max-width: 650px) {
    .column {
      width: 100%;
      display: block;
    }
  }
  
  .center{
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      width: 100px;
      background: rgb(187, 63, 63);
      border-radius: 10px;
      box-shadow: 10px 10px 15px rgba(0,0,0,0.05);
  }
  .center h1{
      text-align: center;
      padding: 20px 0;
      border-bottom: 1px solid silver;
    }
  .center form{
      padding: 0 40px;
      box-sizing: border-box;
    }
    form .txt_field{
      position: relative;
      border-bottom: 2px solid #adadad;
      margin: 30px 0;
    }
    .txt_field input{
      width: 90%;
      padding: 0 5px;
      height: 20px;
      font-size: 16px;
      border: none;
      background: none;
      outline: none;
    }
    .txt_field label{
      position: absolute;
      top: 20%;
      left: 20px;
      color: #adadad;
      transform: translateY(-50%);
      font-size: 16px;
      pointer-events: none;
      transition: .5s;
    }
    .txt_field span::before{
      content: '';
      position: absolute;
      top: 40px;
      left: 0;
      width: 0%;
      height: 2px;
      background: #2691d9;
      transition: .5s;
    }
    .txt_field input:focus ~ label,
    .txt_field input:valid ~ label{
      top: -5px;
      color: #2691d9;
    }
    .txt_field input:focus ~ span::before,
    .txt_field input:valid ~ span::before{
      width: 100%;
    }
    .pass{
      margin: -5px 0 20px 5px;
      color: #a6a6a6;
      cursor: pointer;
    }
    .pass:hover{
      text-decoration: underline;
    }
    .show-button{
      position: absolute;
      left: 90%;
      top: 80%;
      width: 80px;
      height: 70px;
      cursor: pointer;
      border-radius: 30%;
      text-align: center;
      background: rgb(143, 143, 247);
      color: #fff;
    }  
    .show-button i{
      margin:10px 10px;
      font-size: 40px;
    }
    input[type="checkbox"]{
      display: none;
    }
  
    li{
  display:inline;
  padding:32px;
  font-family:sans-serif;
  }
  .foot-color{
    position: fixed;
      bottom: 0;
      left: 0;
     bottom: 0;
     width: 100%;
     background-color: rgb(66, 66, 68);
     color: white;
     padding: 12px;
  }
</style>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"  
crossorigin="anonymous"/>
<script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
</head>
<body>
  <nav>
    <div class="nav-wrapper">
      <img src="data:image/jpeg;base64,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", alt="student market place logo">
      <a class="brand-logo" style="font-size:medium">The Student Market Place</a>
      <ul id="nav-mobile" class="right hide-on-med-and-down">
        <li><a href="/about_us">About Us</a></li>
        <li><a href="/contact_us">Contact Us</a></li>
        <li><a href="/services">Services</a></li>
        <li><a href="student/register/step-1">Register</a></li>
        <li><a href="http://sxt3429.uta.cloud/">Blog</a></li>
        <li><a href="student/login">Sign In</a></li>
        <li><a href="/">Home</a></li>
      </ul>
    </div>
  </nav>
</div>
</div>
<div class="about-section">
  <h4>About Us</h4><br>
  <h6><p>We at Student Market Place, think it's crucial to connect individuals and unleash our collective potential. </p>
    <p>Every day we go to work to create technological solutions that turn people become leaders and staff, students, and alumni into active campus communities.</p>
  <p>The Student Market Place is an online marketplace that is exclusive to college students and staff. </p>
    <p>The marketplace gives students the ability sell or procure items with other students at their university or college. </p>
    <p>The main mission of this Market is to promote sustainable reuse on campus by providing a simple and effective means of initiating exchange within their campus community.</p></h6>
</div>
<div class="row">
  <div class="column">
    <div class="card">
      <div class="container">
        <i class="material-icons prefix">location_on</i>
        <h4 style="color:black">Location</h4>
        <p class="title" style="color: black">University of Texas Arlington</p>
        <p style="color: black">701 S Nedderman Dr, Arlington, TX 76019</p>
        <p style="color:rgb(14, 9, 18)">Email::helpdesk@uta.edu</p>
        <p><a href="/contact_us" class="card-link">Contact</a></p>
      </div>
    </div>
  </div>

  <div class="column">
    <div class="card">
      <div class="container">
        <i class="material-icons prefix">mail</i>
        <h4 style= "color: black" >Mail Us @</h4>
        <p style="color:black">Have any queries?? Feel free to ping us!!</p>
        <p style="color: rgb(4, 3, 5)"> Email::studentmarketplace.uta@gmail.com</p>
        <p><a href="/contact_us" class="card-link">Contact</a></p>
      </div>
    </div>
  </div>

  <div class="column">
    <div class="card">
      <div class="container">
        <i class="material-icons prefix">schedule</i>
        <h4 style="color:black">Working Hours</h2>
        <p style="color:black">Monday-Friday: 8:00 AM to 8:00 PM</p>
        <p style="color:black">Saturday: 8:00 AM to 5:00 PM</p>
        <a href="/contact_us" class="card-link">Contact</a>
      </div>
    </div>
  </div>
</div>
  </div>
<footer class="foot-color">  
  <ul>
    <li><a href="#Phone">PHONE&nbsp;<i class="fas fa-phone-alt"></i></a></li>
    <li><a href="#address">ADDRESS&nbsp;<i class="fa fa-address-book"></i></a></li>
    <li><a href="#email">EMAIL&nbsp;<i class="fa fa-at"></i></a></li>
    <li><a href="#facebook">FACEBOOK&nbsp;<i class="fab fa-facebook-f"></i></a></li>
    <li><a href="#linkedin">LINKEDIN&nbsp;<i class="fab fa-linkedin-in"></i></a></li>
    <li><a href="#instagram">INSTAGRAM&nbsp;<i class="fab fa-instagram"></i></a></li>
    <li><a href="#pinterest">PINTEREST&nbsp;<i class="fab fa-pinterest-p"></i></a></li>
    <li><a href="#twitter">TWITTER&nbsp;<i class="fab fa-twitter"></i></a></li>
    </ul>
      
</footer>
</body> 
</html>