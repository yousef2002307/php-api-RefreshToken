<?php
class JwtCode{
    private $signature = null; 
    public function __construct(string $signature)
    {
        $this->signature = $signature;
    }
 public function encode(array $payload): string{
    $header = json_encode([
        "typ" => "JWT",
        "alg" => "HS256" //created akeyed hash value based on hmac method

    ]);
    $header = $this->base64UrlEncode($header);
    $payload = json_encode($payload);
    $payload = $this->base64UrlEncode($payload);
    $signature = hash_hmac("sha256",
    $header . "." . $payload,
    $this->signature,
    true); // the first argument is the algoritm we gonna use,the seconed is data , the third is key and it must same length as hash valued produced by algo and in has256 the length is 265 key ,the last argument true give us a binary value
    $signature = $this->base64UrlEncode($signature);
    return $header."." . $payload."." . $signature;
} 
 private function base64UrlEncode(string $text) : string{ // give use base64url but with safe use for url
return str_replace(['+',"/","="],['-','_',''],base64_encode($text));
 } 














 public function decode(string $token){
    /*this part of code it isjob to get the signture and payload and header from the text and seperate them */
    if (preg_match("/^(?<header>.+)\.(?<payload>.+)\.(?<signature>.+)$/",
                   $token,
                   $matches) !== 1)  {// <?header> called catch groups
                       
            throw new InvalidArgumentException("invalid token format");
        }
          /*
          print_r($matches);
            (
    [0] => eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjMsIm5hbWUiOiJqbyJ9.GVpi7FI7Y_TCX6qgIOdphx1uag9MeFyEClZAfYIUUeQ
    [header] => eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9
    [1] => eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9
    [payload] => eyJzdWIiOjMsIm5hbWUiOiJqbyJ9
    [2] => eyJzdWIiOjMsIm5hbWUiOiJqbyJ9
    [signature] => GVpi7FI7Y_TCX6qgIOdphx1uag9MeFyEClZAfYIUUeQ
    [3] => GVpi7FI7Y_TCX6qgIOdphx1uag9MeFyEClZAfYIUUeQ
)

        */
        /* in this part of code we gonna make signture from token user entered to chech wheter it match the original signature */
        $signature = hash_hmac("sha256",
        $matches['header'] . "." .  $matches['payload'],
        $this->signature,
        true);
        //first we have to decde the token from user as it was encoded using base64url method

      $signature_from_token = $this->decode64url($matches['signature']);
      if(!hash_equals($signature,$signature_from_token)){ // we used hash_equals instead of comparison operator aas it more secure
       // throw new Exception("signature does not match");
       throw new SignExp;
      }
    $payload = json_decode($this->decode64url($matches['payload']),true)  ;
    if($payload['exp'] < time()){
        throw new TimeExp;
      }
  
    return $payload;
}
private function decode64url(string $text) : string{
    return base64_decode(str_replace(
            ["-", "_"],
            ["+", "/"],
            $text)
        );
 
}

}



