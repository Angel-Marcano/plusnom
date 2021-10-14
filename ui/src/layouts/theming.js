import { fade } from '@material-ui/core/styles/colorManipulator';

const palette = {
  primary: {
    main: '#07021A',  // Negro primario
    light: '#B7B7B7', // Plomo cuaternario
    dark: '#011C2C',  // Negro
  },
  secondary: {
    main: '#FFE835',   // Amarillo segundario
    light: '#E8E8E8',
    dark: '#283436', // Gray
  },
  error: {
    main: '#E02340',  // Rojo
  },
  background: {
    default: '#FFFFFF'
  },
  info: {
    main: '#2280ED' // Azul primario
  }
};

const theme = {
    palette: palette,
    shape: {
        borderRadius: 10,
    },
    overrides: {
        RaLayout: {
            content: {
                marginTop: '4em',
                padding: '0 3em !important'
            },
            appFrame: {
                marginTop: '0 !important'
            }
        },
        RaTopToolbar: {
            root: {
                alignItems: 'center',
                justifyContent: 'space-between'
            },
        },
        RaButton: {
            button: {
                borderRadius: '6px',
                padding: '0.5em 1em',
                textTransform: 'none',
                fontSize: '1em',
                "&[aria-label=Create]": {
                    backgroundColor: palette.secondary.main,
                }
            }
        },
        RaMenuItemLink: {
            root: {
                color: palette.primary.light
            },
            active: {
                borderLeft: `5px solid ${palette.secondary.main}`,
                backgroundColor: fade(palette.secondary.main, 0.16),
                color: palette.secondary.main,
                borderRadius: '6px'
            },
            icon: {
                color: palette.primary.light
            }
        },
        MuiDrawer: {
            root: {
                backgroundColor: palette.primary.main
            }
        },
        MuiMenu: {
            paper: {
                borderRadius: '6px !important',
            }
        },
        MuiPaper: {
            elevation1: {
                boxShadow: 'none',
            },
            root: {
                border: '1px solid #e0e0e3',
                backgroundClip: 'padding-box',
            },
            rounded: {
                borderRadius: '3px !important'
            }
        },
        MuiButton: {
            contained: {
                backgroundColor: '#fff',
                color: '#4f3cc9',
                boxShadow: 'none',
            },
        },
        MuiInputBase: {
            root: {
                border: '1px solid #ced4da',
                borderRadius: 4,
                backgroundColor: palette.background.default,
                padding: '10px 12px !important',
                fontSize: 16,
                borderRadius: '5px',
                transition: "none",
                '&:focus': {
                    borderColor: palette.primary.main
                }
            }
        },
        MuiInputLabel: {
            animated: {
            transition: 'none'
            }
        },
        MuiAppBar: {
            colorSecondary: {
                color: '#808080',
                backgroundColor: '#fff',
            },
        },
        MuiLinearProgress: {
            colorPrimary: {
                backgroundColor: '#f5f5f5',
            },
            barColorPrimary: {
                backgroundColor: '#d7d7d7',
            },
        },
        MuiList: {
            root: {
                padding: '0 !important'
            }
        },
        MuiFilledInput: {
            root: {
                    transition: "none !important",
                    borderRadius: '5px !important',
                    '&$disabled': {
                        backgroundColor: 'rgba(0, 0, 0, 0.04)',
                    }
            },
            underline: {
                '&::before': {
                    content: 'none'
                },
                '&::after': {
                    content: 'none'
                }
            }
        },
        MuiFormHelperText: {
            contained: {
                marginLeft: '7px'
            }
        },
        RaSaveButton: {
            button: {
                backgroundColor: palette.secondary.main,
                color: palette.primary.main,
                borderRadius: '6px',
                textTransform: 'none',
                fontSize: '1em',
                padding: '0.5em 2em'
            }
        },
        RaToolbar: {
            toolbar: {
                display: 'flex',
                flexDirection: 'row',
                backgroundColor: 'transparent',
                justifyContent: "flex-end"
            }
        },
        MuiSnackbarContent: {
            root: {
                border: 'none',
            },
        },
        RaSidebar: {
            root: {
                height: '100vh'
            }
        },
        PrivateTabIndicator: {
            colorPrimary: {
                backgroundColor: palette.info.main
            }
        },
        MuiFormLabel: {
            root: {
                color: palette.primary.main
            }
        },
        MuiInputAdornment: {
            root: {
                color: '#ced4da'
            }
        }
    },
    props: {
        MuiButtonBase: {
            // disable ripple for perf reasons
            disableRipple: true,
        },
    },
}

export default theme;
