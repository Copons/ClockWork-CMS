<?php


function objEmpty ($object) {
	return (is_object($object) && (count(get_object_vars($object)) > 0));
}