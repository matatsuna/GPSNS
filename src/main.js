
class GPSNS {

}

document.addEventListener('DOMContentLoaded', () => {

    const svg = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
    const width = window.innerWidth - 25;
    const height = (window.innerHeight - 25) / 2;
    svg.setAttribute('id', 'drawer');
    svg.setAttribute('preserveAspectRatio', 'xMinYMin meet');
    svg.setAttribute('viewBox', `0 0 ${width} ${height}`);
    svg.setAttribute('x', '0px');
    svg.setAttribute('y', '0px');
    svg.setAttribute('width', `${width}px`);
    svg.setAttribute('height', `${height}px`);
    svg.setAttribute('style', [
        `width: ${width}px;`,
        `height: ${height}px;`,
    ].join(' '));
    document.body.appendChild(svg);

    window.note = new AverageFigureNote('drawer');
});
