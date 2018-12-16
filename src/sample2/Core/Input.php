<?php

namespace Core;
class Input extends Data {

  public function only($attr = []) {
    return array_filter($this->data, function($key) use($attr) {
        return in_array($key, $attr);
      },
      ARRAY_FILTER_USE_KEY
    );
  }

}
