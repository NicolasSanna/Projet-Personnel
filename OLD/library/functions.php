<?php

function asset(string $path): string
{
   return SITE_BASE_URL . '/' . $path;
}