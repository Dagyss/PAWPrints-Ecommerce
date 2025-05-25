export default class SearchComponent {
    constructor({ formSelector, inputSelector, historyContainerSelector, storageKey = 'searchHistory', max = 5, onSearch }) {
      this.form = document.querySelector(formSelector);
      this.input = document.querySelector(inputSelector);
      this.historyContainer = document.querySelector(historyContainerSelector);
      this.storageKey = storageKey;
      this.max = max;
      this.onSearch = onSearch;
      this.form.addEventListener('submit', e => this.onSubmit(e));
      this.input.addEventListener('focus', () => this.renderHistory());
      this.input.addEventListener('input', () => this.renderHistory());
      document.addEventListener('click', e => {
        if (!this.form.contains(e.target)) this.clearHistoryList();
      });
    }
  
    getHistory() {
      const raw = localStorage.getItem(this.storageKey);
      return raw ? JSON.parse(raw) : [];
    }
  
    saveHistory(arr) {
      localStorage.setItem(this.storageKey, JSON.stringify(arr));
    }
  
    onSubmit(e) {
      const q = this.input.value.trim();
      if (!q) return;
      e.preventDefault();
  
      let history = this.getHistory();
      history = history.filter(item => item !== q);
      history.unshift(q);
      if (history.length > this.max) history = history.slice(0, this.max);
      this.saveHistory(history);
      this.onSearch?.(q);
    }
  
    renderHistory() {
      const history = this.getHistory();
      if (!history.length) {
        this.clearHistoryList();
        return;
      }
      this.historyContainer.innerHTML = history
        .map(item => `<li class="history-item">${item}</li>`)
        .join('');
      this.historyContainer.querySelectorAll('.history-item').forEach(li => {
        li.addEventListener('click', () => {
          this.input.value = li.textContent;
          this.form.requestSubmit();
        });
      });
    }
  
    clearHistoryList() {
      this.historyContainer.innerHTML = '';
    }
  }