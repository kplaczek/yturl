<?php

/**
 * Get raw fideo file url from 11 chars long youtube video id.
 *
 * @author kplaczek
 * @link https://github.com/kplaczek/yturl github repository and help source about this class
 */
class yturl {

    private $ytVideoId = null;
    private $filesData = array();

    const get_video_info_url = 'http://youtube.com/get_video_info?video_id=';

    public function __construct($ytVideoId) {
        try {
            $this->isIdValid($ytVideoId);
            $this->ytVideoId = $ytVideoId;
            $this->getRawData();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getInfo() {
        return $this->filesData;
    }

    private function getVideoInfoUrl() {
        return self::get_video_info_url . $this->ytVideoId;
    }

    private function getRawData() {
        $data = file_get_contents($this->getVideoInfoUrl());
        if (!$data) {
            throw Exception('Failed to download data');
        }
        $rawData = mb_convert_encoding($data, 'HTML-ENTITIES', "UTF-8");
        parse_str($rawData, $resultArray);

        if (isset($resultArray['status']) && $resultArray['status'] !== 'ok') {
            throw new Exception($resultArray['reason'], $resultArray['errorcode']);
        }

        foreach (explode(',', $resultArray['url_encoded_fmt_stream_map']) as $stream) {
            parse_str($stream, $realStreamInfo);
            $this->filesData[] = $realStreamInfo;
        }
    }

    private function isIdValid($ytVideoId) {
        if (strlen($ytVideoId) !== 11 || !preg_match('#[a-zA-Z0-9\-_]{11}#', $ytVideoId)) {
            throw new Exception('Wrong youtube video id.');
        }
        return true;
    }

}
