<?php

class HTML {




// Echo self closing tag

public static function tag ($tag, $attributes, $echo = true) {
	if ($echo) :
		echo '<' . $tag . ' ';
		foreach ($attributes as $name => $value) :
			echo $name . '="' . $value . '" ';
		endforeach;
		echo "/>\n";
	else :
		$output = '<' . $tag . ' ';
		foreach ($attributes as $name => $value) :
			$output .= $name . '="' . $value . '" ';
		endforeach;
		$output .= "/>\n";
		return $output;
	endif;
}




// Echo container tags opening (or opening - inner HTML - closing)

public static function ctag ($tag, $attributes, $inner = false, $echo = true) {
	if ($echo) :
		echo '<' . $tag;
		if (is_array($attributes)) :
			echo ' ';
			foreach ($attributes as $name => $value) :
				echo $name . '="' . $value . '" ';
			endforeach;
		endif;
		echo ">";
		if ($inner) :
			if (is_string($inner)) :
				echo $inner;
			endif;
			echo '</' . $tag . ">\n";
		endif;
	else :
		$output = '<' . $tag;
		if (is_array($attributes)) :
			$output .= ' ';
			foreach ($attributes as $name => $value) :
				$output .= $name . '="' . $value . '" ';
			endforeach;
		endif;
		$output .= ">";
		if ($inner) :
			if (is_string($inner)) :
				$output .= $inner;
			endif;
			$output .= '</' . $tag . ">\n";
		endif;
		return $output;
	endif;
}





}