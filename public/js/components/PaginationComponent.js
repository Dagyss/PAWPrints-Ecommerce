export default class PaginationComponent {

    constructor(container, totalItems, pageSize, onPageChange) {
        this.container = container;
        this.totalItems = totalItems;
        this.pageSize = pageSize;
        this.onPageChange = onPageChange;
        this.currentPage = 1;
        this.render();
    }

    setTotalItems(totalItems) {
        this.totalItems = totalItems;
        const maxPage = this.getMaxPage();
        if (this.currentPage > maxPage) this.currentPage = maxPage;
        this.render();
    }

    goToPage(page) {
        const maxPage = this.getMaxPage();
        if (page < 1 || page > maxPage) return;
        this.currentPage = page;
        this.render();
        this.onPageChange(this.currentPage);
    }

    getMaxPage() {
        return Math.ceil(this.totalItems / this.pageSize) || 1;
    }

    render() {
        this.container.innerHTML = '';
        const maxPage = this.getMaxPage();

        const wrapper = document.createElement('div');
        wrapper.classList.add('pagination-buttons');

        // Previous
        const prevBtn = document.createElement('button');
        prevBtn.textContent = '«';
        prevBtn.disabled = this.currentPage === 1;
        prevBtn.classList.add('page-btn');
        prevBtn.addEventListener('click', () => this.goToPage(this.currentPage - 1));
        wrapper.appendChild(prevBtn);

        // Page numbers
        for (let i = 1; i <= maxPage; i++) {
            const btn = document.createElement('button');
            btn.textContent = i;
            btn.disabled = i === this.currentPage;
            btn.classList.add('page-btn');
            if (i === this.currentPage) btn.classList.add('active');
            btn.addEventListener('click', () => this.goToPage(i));
            wrapper.appendChild(btn);
        }

        // Next
        const nextBtn = document.createElement('button');
        nextBtn.textContent = '»';
        nextBtn.disabled = this.currentPage === maxPage;
        nextBtn.classList.add('page-btn');
        nextBtn.addEventListener('click', () => this.goToPage(this.currentPage + 1));
        wrapper.appendChild(nextBtn);

        this.container.appendChild(wrapper);
    }
}