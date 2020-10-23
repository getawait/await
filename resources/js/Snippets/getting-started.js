// todo: figure out a way to improve this
export default {
  js: `
  var myHeaders = new Headers();
  myHeaders.append("X-Requested-With", "XMLHttpRequest");
  myHeaders.append("Content-Type", "application/x-www-form-urlencoded");
  
  var urlencoded = new URLSearchParams();
  urlencoded.append("email", "balazs3@otakomaiya.com");
  urlencoded.append("waitlist", "c4e92835-1b14-438f-a743-da92167ae2bc");
  
  var requestOptions = {
    method: 'POST',
    headers: myHeaders,
    body: urlencoded,
    redirect: 'follow'
  };
  
  fetch("http://127.0.0.1:8000/api/v1/subscribers", requestOptions)
    .then(response => response.text())
    .then(result => console.log(result))
    .catch(error => console.log('error', error));
  `,
  php: `
  <?php
  
  $curl = curl_init();
  
  curl_setopt_array($curl, array(
    CURLOPT_URL => "http://127.0.0.1:8000/api/v1/subscribers",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => "email=balazs3@otakomaiya.com&waitlist=c4e92835-1b14-438f-a743-da92167ae2bc",
    CURLOPT_HTTPHEADER => array(
      "X-Requested-With: XMLHttpRequest",
      "Content-Type: application/x-www-form-urlencoded"
    ),
  ));
  
  $response = curl_exec($curl);
  
  curl_close($curl);
  echo $response;
  `,
}