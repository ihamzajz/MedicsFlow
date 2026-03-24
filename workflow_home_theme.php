<style>
body {
  background-color: #f2f3f5 !important;
}

.container .row,
.container-fluid .row {
  row-gap: 1rem;
}

.container .col-md-5,
.container-fluid .col-md-5 {
  width: 100% !important;
  max-width: 100% !important;
  flex: 0 0 100% !important;
}

.home-shell {
  background: transparent !important;
  border: 0 !important;
  box-shadow: none !important;
  padding: 0 !important;
}

.home-heading {
  border-radius: 18px !important;
  padding: 22px 24px !important;
  background: linear-gradient(135deg, #0f172a, #1e3a8a, #3b82f6) !important;
  border: 1px solid rgba(255, 255, 255, 0.15) !important;
  box-shadow: 0 18px 40px rgba(15, 23, 42, 0.45) !important;
  margin: 0 0 22px !important;
  color: #ffffff !important;
  font-size: 20px !important;
  font-weight: 800 !important;
  line-height: 1.25 !important;
  letter-spacing: 0.4px !important;
}

.inner-card {
  display: grid !important;
  grid-template-columns: repeat(auto-fit, minmax(194px, 1fr)) !important;
  gap: 14px !important;
  background: transparent !important;
  border: 0 !important;
  box-shadow: none !important;
  overflow: visible !important;
}

.section-title {
  grid-column: 1 / -1 !important;
  margin: 7px 0 -7px !important;
  padding: 0 2px !important;
  font-size: 13.5px !important;
  font-weight: 700 !important;
  font-family: 'Poppins', sans-serif !important;
  color: #22223b !important;
  background: transparent !important;
  border-top: 0 !important;
  text-transform: none !important;
  letter-spacing: normal !important;
}

.section-title.first {
  border-top: 0 !important;
  margin-top: 0 !important;
}

.menu-item {
  position: relative !important;
  overflow: hidden !important;
  display: flex !important;
  flex-direction: column !important;
  align-items: center !important;
  justify-content: center !important;
  text-align: center !important;
  gap: 3px !important;
  min-height: 92px !important;
  padding: 3px 13px !important;
  text-decoration: none !important;
  color: inherit !important;
  background: #ffffff !important;
  border: 1px solid #e5e7eb !important;
  border-radius: 14px !important;
  box-shadow: 0 14px 32px rgba(0, 0, 0, 0.12) !important;
  transition: all 0.22s ease !important;
}

.menu-item:hover {
  transform: translateY(-6px) !important;
  box-shadow: 0 26px 55px rgba(0, 0, 0, 0.2) !important;
  color: inherit !important;
}

.menu-icon {
  width: 42px !important;
  height: 42px !important;
  border-radius: 50% !important;
  display: inline-flex !important;
  align-items: center !important;
  justify-content: center !important;
  flex: 0 0 42px !important;
  font-size: 16px !important;
  color: #ffffff !important;
  margin-bottom: 8px !important;
}

.icon-green {
  background: #22c55e !important;
}

.icon-blue {
  background: #3b82f6 !important;
}

.icon-amber {
  background: #f59e0b !important;
}

.menu-label,
.menu-item span:nth-of-type(2) {
  display: block !important;
  font-size: 11.5px !important;
  font-weight: 700 !important;
  color: #4a4e69 !important;
  line-height: 1.1 !important;
}

.menu-desc {
  display: none !important;
  max-width: 160px !important;
  font-size: 11px !important;
  line-height: 1.3 !important;
  color: #64748b !important;
  font-weight: 500 !important;
}

@media (max-width: 767.98px) {
  .inner-card {
    grid-template-columns: 1fr !important;
  }
}
</style>
