/**
 * KitActionPanel – custom element for the home page.
 *
 * Usage:
 *   <kit-action-panel
 *     data-shop="/shop"
 *     data-register="/kit-developer-registration">
 *   </kit-action-panel>
 *
 * "Find a Kit"  → kit makers   → shop page
 * "Become a Kit Developer" → kit developers → registration page
 */
class KitActionPanel extends HTMLElement {
    connectedCallback() {
        const shopUrl     = this.dataset.shop     || '/shop';
        const registerUrl = this.dataset.register || '/kit-developer-registration';

        this.innerHTML = `
            <div class="kit-panel">
                <h2>Kits for every family moment.</h2>
                <p>Looking for a kit to build together, or ready to share your ideas as a kit developer?</p>
                <div class="kit-panel-buttons">
                    <a href="${shopUrl}"     class="btn-kit primary">Find a Kit</a>
                    <a href="${registerUrl}" class="btn-kit secondary">Become a Kit Developer</a>
                </div>
            </div>
        `;
    }
}

customElements.define('kit-action-panel', KitActionPanel);

/* ─── Live word-counter for the developer registration textarea ──────────── */
document.addEventListener('DOMContentLoaded', function () {
    const textarea = document.getElementById('dev_summary');
    const counter  = document.getElementById('word-count-display');
    if (!textarea || !counter) return;

    function countWords(text) {
        return text.trim() === '' ? 0 : text.trim().split(/\s+/).length;
    }

    function updateCounter() {
        const count = countWords(textarea.value);
        counter.textContent = count;
        counter.style.color = (count >= 80 && count <= 120) ? '#2D6A4F' : '#c0392b';
    }

    textarea.addEventListener('input', updateCounter);
    updateCounter();
});
