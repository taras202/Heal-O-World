<style>
  .stepper {
    border-left: 2px solid #ccc;
    padding-left: 20px;
    margin-left: 10px;
  }

  .step {
    display: flex;
    align-items: center;
    margin-bottom: 20px;
  }

  .circle {
    width: 24px;
    height: 24px;
    border-radius: 50%;
    background: #ccc;
    color: white;
    text-align: center;
    line-height: 24px;
    font-weight: bold;
    margin-right: 10px;
  }

  .active .circle {
    background: #007bff;
  }

  .active span {
    font-weight: bold;
    color: #007bff;
  }
</style>

<div class="step active">
  <div class="circle">1</div>
  <span>Персональні дані</span>
</div>
  <div class="step">
    <div class="circle">2</div>
    <span>Спеціалізація</span>
  </div>
  <div class="step">
    <div class="circle">3</div>
    <span>Освіта</span>
  </div>
</div>
