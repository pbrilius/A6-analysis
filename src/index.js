import _ from 'lodash';
import 'bootstrap';

@import "custom";
@import "~bootstrap/scss/bootstrap";

function component() {
    const element = document.createElement('div');
  
    element.innerHTML = _.join(['Hello', 'webpack'], ' ');
  
    return element;
  }
  
  document.body.appendChild(component());