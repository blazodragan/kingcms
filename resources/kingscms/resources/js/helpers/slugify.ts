
export const slugify = (str?: string) => {
  if (typeof str === 'undefined' || str === null) {
    return '';
  }
  return str
    .toLowerCase()
    .replace(/[^\w \-]+/g, '') 
    .replace(/ +/g, '-')
    .trim();
};