<style>
.stepper {
  position: sticky; 
  top: 40px;
  padding-left: 30px;
  border-left: 3px solid #e5e7eb;
  margin-left: 20px;
  margin-top: 40px;
  max-height: calc(100vh - 80px);
}

.stepper::before {
  content: '';
  position: absolute;
  top: 0;
  left: -1.5px;
  width: 3px;
  height: 100%;
  background: #e5e7eb;
  border-radius: 1px;
}

.step {
  position: relative;
  display: flex;
  align-items: center;
  margin-bottom: 50px;
}

.circle {
  width: 40px;
  height: 40px;
  border-radius: 50%;
  background: #e5e7eb;
  color: #374151;
  font-weight: 600;
  font-size: 18px;
  text-align: center;
  line-height: 40px;
  margin-right: 20px;
  transition: all 0.3s ease;
  box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
}

.step span {
  font-size: 18px;
  color: #6b7280;
  font-weight: 500;
  transition: all 0.3s;
}

.step.active .circle {
  background: #e5e7eb;
  color: white;
  transform: scale(1.1);
  box-shadow: 0 0 15px rgba(59, 130, 246, 0.5);
}

.step.active span {
  color: #1e40af;
  font-weight: 700;
}

@media (max-width: 768px) {
  .stepper {
    position: static; 
    border-left: none;
    padding-left: 0;
    margin-left: 0;
  }

  .step {
    margin-bottom: 30px;
  }
}
</style>

<div class="hidden lg:flex w-1/4 justify-center">
  <div class="stepper">
    <div class="step {{ $step >= 1 ? 'active' : '' }}">
      <div class="circle">1</div>
      <span>Персональні дані</span>
    </div>
    <div class="step {{ $step >= 2 ? 'active' : '' }}">
      <div class="circle">2</div>
      <span>Спеціалізація</span>
    </div>
    <div class="step {{ $step >= 3 ? 'active' : '' }}">
      <div class="circle">3</div>
      <span>Освіта</span>
    </div>
  </div>
</div>
