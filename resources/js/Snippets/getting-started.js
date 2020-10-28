// todo: figure out a way to improve this
const gettingStarted = ({ waitlistId }) => (language) => {
  switch (language) {
    case 'js':
      return `
        var myHeaders = new Headers();
        myHeaders.append("X-Requested-With", "XMLHttpRequest");
        myHeaders.append("Content-Type", "application/x-www-form-urlencoded");
        
        var urlencoded = new URLSearchParams();
        urlencoded.append("email", "your.email@address.com");
        urlencoded.append("waitlist", "${ waitlistId }");
        
        var requestOptions = {
          method: 'POST',
          headers: myHeaders,
          body: urlencoded,
          redirect: 'follow'
        };
        
        fetch("https://getawait.com/api/v1/subscribers", requestOptions)
          .then(response => response.text())
          .then(result => console.log(result))
          .catch(error => console.log('error', error));
      `;
    case 'php':
      return `
        <?php
        
        $curl = curl_init();
        
        curl_setopt_array($curl, array(
          CURLOPT_URL => "https://getawait.com/api/v1/subscribers",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "POST",
          CURLOPT_POSTFIELDS => "email=your.email@address.com&waitlist=${ waitlistId }",
          CURLOPT_HTTPHEADER => array(
            "X-Requested-With: XMLHttpRequest",
            "Content-Type: application/x-www-form-urlencoded"
          ),
        ));
        
        $response = curl_exec($curl);
        
        curl_close($curl);
        echo $response;
        `;
  }
}

export default gettingStarted;