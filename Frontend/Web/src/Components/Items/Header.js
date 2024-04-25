import React from 'react';
import '../../Scss/Main.scss';
import Exit from '../../Images/icons8-log-out-64.png'
import Video from '../../Images/icons8-video-64.png'

const Header = () => {
  return (
    <div className='Header'>
        <img src={Video} alt="Video" />
        <img src={Exit} alt="Exit" />
    </div>
  )
}

export default Header