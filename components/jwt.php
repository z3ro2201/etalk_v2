<?php
class JWT
{
    protected $alg;
    protected $secret_key;

    function __construct(){
        // Algorithm
        $this->alg = 'SHA256';

        // Secret key
        $this->secret_key = "KEY";
    }

    // JWT 발급
    function hashing(array $data): string
    {
        //Header
        $header = json_encode(array(
            'alg' => $this->alg,
            'typ' => 'JWT'
        ));

        // payload
        $payload = json_encode($data);

        // signing
        $signature = hash($this->alg, $header.$payload.$this->secret_key);

        $encode_header = base64_encode($header);
        $encode_payload = base64_encode($payload);

        //return $encode_header.".".$encode_payload.".".$signature;
        return base64_encode($header.'.'.$payload.'.'.$signature);
    }

    // JWT 해석
    function dehasing($token) {
        // 구분자는 '.' 단위
        $parted = explode('.', base64_decode($token));
        $signature = $parted[2];

        // signature 생성 후 비교
        if(hash($this->alg, $parted[0] . $parted[1] . $this->secret_key) != $signature) {
            return "signature error";
        }

        // 만료검사
        $payload = json_decode($parted[1], true);
        if($payload['exp'] < time()) {
            return "expired error";
        }

        return json_decode($parted[1], true);
    }
}