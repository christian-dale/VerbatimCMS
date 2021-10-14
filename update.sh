#!/bin/bash

curl "https://api.github.com/repos/christian-dale/portfolio-cms/tags" |
    jq -r '.[0].zipball_url'
