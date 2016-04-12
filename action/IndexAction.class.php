<?php
/**
 * @author ShiO
 */
class IndexAction{
    public function index(Request $request){
        $request->getRequestMessage();
        echo 1;
    }
}