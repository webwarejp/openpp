#!/bin/bash

if [ ! -f bin/yuicompressor.jar ];then
  curl -L https://github.com/yui/yuicompressor/releases/download/v2.4.8/yuicompressor-2.4.8.jar > bin/yuicompressor.jar;
fi;

