export default class SiteHeader {
    init()
    {
        this.siteHeaderElement = document.getElementById('site-header');

        if (!this.siteHeaderElement) {
            return;
        }

        this.burgerButton = this.siteHeaderElement.querySelector(
            '.site-header__burger-button'
        );

        this.mainMenuItemButtons = Array.from(
            this.siteHeaderElement.querySelectorAll(
                '.site-header__main-menu-item-button'
            )
        );

        this.mainMenuPanelCloseButtons = Array.from(
            this.siteHeaderElement.querySelectorAll(
                '.site-header-panel__close-button'
            )
        );

        this.mainMenuPanelSectionButtons = Array.from(
            this.siteHeaderElement.querySelectorAll(
                '.site-header-panel__section-list-item-button'
            )
        );

        console.log(this.mainMenuPanelSectionButtons);

        this.burgerButton.addEventListener(
            'click',
            () => {
            const force = !this.burgerButton.classList.contains(
                    'burger-menu-is-active'
                );
            this.burgerButton.classList.toggle('burger-menu-is-active', force);
            this.toggleBurgerMenu(force);
            if (!force) {
                this.disabledAllActiveElements();

                this.checkIfOnePanelIsActive();
            }
            },
            window.supportPassive
        );

        for (const button of this.mainMenuItemButtons) {
            button.addEventListener(
                'click',
                () => {
                if (button.classList.contains('is-active')) {
                    this.togglePanel(button);
                } else {
                this.disabledAllActiveElements();
                this.togglePanel(button);
                }
                },
                window.supportPassive
            );
        }

        for (const closeButton of this.mainMenuPanelCloseButtons) {
            closeButton.addEventListener(
                'click',
                () => {
                this.togglePanel(closeButton, false);
                },
                window.supportPassive
            );
        }

        for (const button of this.mainMenuPanelSectionButtons) {
            button.addEventListener(
                'click',
                () => {
                if (button.classList.contains('is-active')) {
                    this.toggleSectionPanel(button);
                } else {
                this.disabledAllActiveElements();
                this.toggleSectionPanel(button);
                }
                },
                window.supportPassive
            );
        }
    }

    disabledAllActiveElements()
    {
        Array.from(this.siteHeaderElement.querySelectorAll('.is-active')).forEach(
            (element) => {
            element.classList.remove('is-active');
            }
        );
    }

    toggleBurgerMenu(force = undefined)
    {
        force =
            force === undefined
                ? !this.siteHeaderElement.classList.contains('has-burger-menu-active')
                : force;

        this.siteHeaderElement.classList.toggle('has-burger-menu-active', force);
    }

    togglePanel(button, force = undefined)
    {
        const buttonTarget = button.getAttribute('data-panel-target');
        const panel = document.getElementById(buttonTarget);

        const otherButtons = Array.from(
            this.siteHeaderElement.querySelectorAll(
                `[data-panel-target="${buttonTarget}"]`
            )
        );

        force =
            force === undefined ? !button.classList.contains('is-active') : force;

        button.classList.toggle('is-active', force);
        button.blur();
        panel.classList.toggle('is-active', force);

        for (const otherButton of otherButtons) {
            otherButton.classList.toggle('is-active', force);

            if (
                !force &&
                otherButton.classList.contains('site-header__main-menu-item-button')
            ) {
                otherButton.focus();
            } else if (force) {
                panel.focus();
            }
        }

        this.checkIfOnePanelIsActive();
    }

    checkIfOnePanelIsActive()
    {
        const openPanels = Array.from(
            this.siteHeaderElement.querySelectorAll('.is-active')
        );

        this.siteHeaderElement.classList.toggle(
            'has-one-panel-active',
            openPanels.length > 0
        );
    }

    toggleSectionPanel(button, force = undefined)
    {
        const buttonTarget = button.getAttribute('data-panel-section-target');
        const panel = document.getElementById(buttonTarget);

        const otherButtons = Array.from(
            this.siteHeaderElement.querySelectorAll(
                `[data-section-panel-target="${buttonTarget}"]`
            )
        );

        force =
            force === undefined ? !button.classList.contains('is-active') : force;

        button.classList.toggle('is-active', force);
        button.blur();
        panel.classList.toggle('is-active', force);

        for (const otherButton of otherButtons) {
            otherButton.classList.toggle('is-active', force);

            if (
                !force &&
                otherButton.classList.contains('site-header__main-menu-item-button')
            ) {
                otherButton.focus();
            } else if (force) {
                panel.focus();
            }
        }

        this.checkIfOnePanelIsActive();
    }
}
