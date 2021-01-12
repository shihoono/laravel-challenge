window.addEventListener('DOMContentLoaded', () => {

    const endTime = new Date(endTimeJson);
    const now = new Date(nowTimeJson);
    let currentTimeCount = now.getTime();
  
    const countUp = () => {
      currentTimeCount += 1000;
    }
  
    const getCounter = () => {
      const remainingTime = endTime - currentTimeCount;
      if (remainingTime < 0) {
        return null;
      }
      const sec = Math.floor(remainingTime / 1000 % 60);
      const min = Math.floor(remainingTime / 1000 / 60) % 60;
      const hours = Math.floor(remainingTime / 1000 / 60 / 60) % 24;
      const days = Math.floor(remainingTime / 1000 / 60 / 60 / 24);
      const count = [days, hours, min, sec]; 
      
      return count;
    };
  
    const update = () => {
      const counter = getCounter();
      if(counter){
        const showCountdown = '残り' + counter[0] + '日' + counter[1] + '時間' + counter[2] + '分' + counter[3] + '秒';
        document.getElementById('countdownTimerDisplay').textContent = showCountdown;
        perSecond();
      } else {
        document.getElementById('countdownTimerDisplay').textContent = 'オークションは終了しました';
      }
    };
  
    const perSecond = () => {
      setTimeout(() => {
        countUp();
        update();
      }, 1000);
    };
    
    update();
  
  }, false); 
  